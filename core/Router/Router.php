<?php

namespace Core\Router;

class Router
{
    public static array $routes = [];

    public static function get(string $path, array $action): Route
    {
        return self::addRoute('GET', $path, $action);
    }

    public static function post(string $path, array $action): Route
    {
        return self::addRoute('POST', $path, $action);
    }

    public static function put(string $path, array $action): Route
    {
        return self::addRoute('PUT', $path, $action);
    }

    public static function patch(string $path, array $action): Route
    {
        return self::addRoute('PATCH', $path, $action);
    }

    public static function delete(string $path, array $action): Route
    {
        return self::addRoute('DELETE', $path, $action);
    }

    public static function match(array $methods, string $path, array $action): Route
    {
        return self::addRoute($methods, $path, $action);
    }
    
    public static function addRoute(string | array $methods, string $path, array $action): Route
    {
        self::validateMethods(is_array($methods) ? array_map('strtoupper', $methods) : strtoupper($methods));

        $route = new Route($path, $action);

        if (is_array($methods)) {
            foreach ($methods as $method) {
                self::$routes[$method][] = $route;
            }
        } else {
            self::$routes[$methods][] = $route;
        }

        return $route;
    }

    private static function validateMethods(string | array $methods): void
    {
        $validMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'HEAD'];

        $validate = static function (string $method) use ($validMethods) {
            if (!in_array($method, $validMethods)) {
                throw new \InvalidArgumentException("Invalid HTTP method: $method");
            }
        };

        if (is_array($methods)) {
            foreach ($methods as $method) {
                $validate($method);
            }
        } else {
            $validate($methods);
        }
    }

    public static function resolve(string $method, string $path): ?Route
    {
        foreach (self::$routes[$method] ?? [] as $route) {
            if ($route->getPath() === $path) {
                return $route;
            }
        }

        return null;
    }
}