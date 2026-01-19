<?php

declare(strict_types=1);

namespace Core\Http;

class Request
{
    private array $queryParams;
    private array $bodyParams;
    private array $serverParams;
    private array $fileParams;
    private array $cookies;
    private string $method;
    private string $uri;
    private Session $session;

    public function __construct(
        array $queryParams = [],
        array $bodyParams = [],
        array $serverParams = [],
        array $fileParams = [],
        array $cookies = [],
        ?string $uri = null,
        ?string $method = null
    ) {
        $this->queryParams = $queryParams;
        $this->bodyParams = $bodyParams;
        $this->serverParams = $serverParams;
        $this->fileParams = $fileParams;
        $this->cookies = $cookies;
        $this->method = $method ?? $this->serverParams['REQUEST_METHOD'] ?? 'GET';
        $this->uri = $uri ?? $this->serverParams['REQUEST_URI'] ?? '/';
        $this->session = new Session();
    }

    public static function capture(): self
    {
        return new self(
            $_GET,
            $_POST,
            $_SERVER,
            $_FILES,
            $_COOKIE
        );
    }

    public function session(): Session
    {
        return $this->session;
    }

    public function getSession(string $key, mixed $default = null): mixed
    {
        return $this->session->get($key, $default);
    }

    public function setSession(string $key, mixed $value): void
    {
        $this->session->set($key, $value);
    }

    public function getMethod(): string
    {
        return strtoupper($this->method);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getPath(): string
    {
        $path = parse_url($this->uri, PHP_URL_PATH);
        return $path === '' || $path === false ? '/' : $path;
    }

    public function isMethod(string $method): bool
    {
        return $this->getMethod() === strtoupper($method);
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->bodyParams[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->bodyParams[$key] ?? $this->queryParams[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->queryParams, $this->bodyParams);
    }
}