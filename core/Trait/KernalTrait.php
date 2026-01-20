<?php

namespace Core\Trait;

use Core\Controller\AbstractController;
use Core\Database\Connection;
use Core\Http\Request;
use Core\Http\Response;
use Core\Router\Router;
use Core\Utils\ViewUtil;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

trait KernalTrait
{
    public function run(): void
    {
        $this->runEnvironment();
        $this->runConnection();
        $this->runTwig();
        $this->runHttp();
    }

    public function runEnvironment(): void
    {
        Dotenv::createImmutable($this->projectDir)->load();
    }

    public function runTwig(): void
    {
        $twig = new Environment(new FilesystemLoader(dirname(__DIR__, 2) . '/views'));
        $this->container->bind(Environment::class, $twig);
    }

    private function runConnection(): void
    {
        $connection = new Connection(getenv('DB_HOST'), getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));
        $this->container->bind(Connection::class, $connection);
    }

    private function runHttp(): void
    {
        $request = Request::capture();

        $this->container->bind(Request::class, $request);

        $routesFile = dirname(__DIR__, 2) . '/route/web.php';
        if (file_exists($routesFile)) {
            require_once $routesFile;
        }

        $method = $request->getMethod();
        $path = $request->getPath();

        $route = Router::resolve($method, $path);

        if (!$route) {
            new Response(ViewUtil::renderView('errors/404'), 404)->send();
            return;
        }

        $action = $route->getAction();
        [$controllerClass, $methodName] = $action;

        // Create the core action (the final step in the pipeline)
        $next = function (Request $request) use ($controllerClass, $methodName) {
            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Controller $controllerClass not found");
            }

            /**
             * @var AbstractController $controllerInstance
             */
            $controllerInstance = $this->container->get($controllerClass);
            /**
             * @var Environment $environment
             */
            $environment = $this->container->get(Environment::class);

            $controllerInstance->setEnvironment($environment);

            if (!method_exists($controllerInstance, $methodName)) {
                throw new \RuntimeException("Method $methodName not found in $controllerClass");
            }

            $reflection = new \ReflectionMethod($controllerInstance, $methodName);

            if ($reflection->getReturnType()?->getName() !== Response::class) {
                throw new \RuntimeException('The method must return a Response object');
            }

            return $this->container->call([$controllerInstance, $methodName]);
        };

        $middlewares = array_reverse($route->getMiddlewares());

        $pipeline = array_reduce(
            $middlewares,
            static function ($stack, $middlewareClass) {
                return static function (Request $request) use ($stack, $middlewareClass) {
                    if (!class_exists($middlewareClass)) {
                        throw new \RuntimeException("Middleware $middlewareClass not found");
                    }
                    return new $middlewareClass()->handle($request, $stack);
                };
            },
            $next
        );

        $response = $pipeline($request);

        $response->send();
    }
}