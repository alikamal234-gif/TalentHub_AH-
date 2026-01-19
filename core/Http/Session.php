<?php

declare(strict_types=1);

namespace Core\Http;

class Session
{
    public function __construct()
    {
        $this->start();
    }

    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
            session_destroy();
            $_SESSION = [];
        }
    }

    public function flash(string $key, mixed $value): void
    {
        $this->set("_flash_$key", $value);
    }

    public function getFlash(string $key, mixed $default = null): mixed
    {
        $value = $this->get("_flash_$key", $default);
        $this->remove("_flash_$key");
        return $value;
    }

    public function all(): array
    {
        return $_SESSION;
    }
}
