<?php

declare(strict_types=1);

namespace Core\Http;

use JetBrains\PhpStorm\NoReturn;

class Redirect
{
    /**
     * Redirect to a specific URL.
     *
     * @param string $url
     * @param int $statusCode
     * @return void
     */
    #[NoReturn]
    public static function to(string $url, int $statusCode = 302): void
    {
        if (!headers_sent()) {
            header("Location: $url", true, $statusCode);
            exit;
        }

        exit;
    }

    /**
     * Redirect back to the previous page.
     *
     * @param int $statusCode
     * @param string $fallback
     * @return void
     */
    public static function back(int $statusCode = 302, string $fallback = '/'): void
    {
        $url = $_SERVER['HTTP_REFERER'] ?? $fallback;
        self::to($url, $statusCode);
    }

    /**
     * Refresh the current page.
     *
     * @return void
     */
    public static function refresh(): void
    {
        self::to($_SERVER['REQUEST_URI'] ?? '/');
    }
}
