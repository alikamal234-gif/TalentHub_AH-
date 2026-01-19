<?php

namespace Core\Router;
use Core\Controller\AbstractController;

class Route
{
    /** @var string[] */
    private array $middlewares = [];

    /**
     * @param string $path
     * @param array<AbstractController, string> $action
     */
    public function __construct(
        private string $path,
        private array $action
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array<AbstractController, string>
     */
    public function getAction(): array
    {
        return $this->action;
    }

    /**
     * @param string|string[] $middleware
     * @return $this
     */
    public function middleware(string|array $middleware): self
    {
        if (is_array($middleware)) {
            $this->middlewares = array_merge($this->middlewares, $middleware);
        } else {
            $this->middlewares[] = $middleware;
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}