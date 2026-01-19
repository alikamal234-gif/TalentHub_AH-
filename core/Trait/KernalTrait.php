<?php

namespace Core\Trait;

use Core\Http\Request;
use Core\Http\Response;
use Core\Router\Router;
use Core\Utils\ViewUtil;

trait KernalTrait
{
    public function run(): void
    {
        $request = Request::capture();

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
        $next = static function (Request $request) use ($controllerClass, $methodName) {
            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Controller $controllerClass not found");
            }

            $controller = new $controllerClass();
            if (!method_exists($controller, $methodName)) {
                throw new \RuntimeException("Method $methodName not found in $controllerClass");
            }

            $reflection = new \ReflectionMethod($controller, $methodName);

            if ($reflection->getReturnType()?->getName() !== Response::class) {
                throw new \RuntimeException('The method must return a Response object');
            }

            $args = [];
            if ($reflection->getNumberOfParameters() > 0) {
                $args[] = $request;
            }

            return $controller->$methodName(...$args);
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