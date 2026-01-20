<?php

declare(strict_types=1);

namespace Core\Controller;

use Core\Http\Redirect;
use Core\Http\Response;
use Core\Utils\ViewUtil;
use JetBrains\PhpStorm\NoReturn;
use RuntimeException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class AbstractController
{
    private Environment $environment;

    public function setEnvironment(Environment $environment): static
    {
        $this->environment = $environment;
        return $this;
    }

    protected function render(string $path, array $data = []): Response
    {
        return new Response($this->environment->render($path, $data));
    }

    protected function redirectToPath(string $path): void
    {
        Redirect::to($path);
    }
}