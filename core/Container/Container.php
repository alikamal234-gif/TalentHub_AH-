<?php

namespace Core\Container;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use RuntimeException;

class Container
{
    private array $bindings = [];

    public function bind(string $key, object | string $concrete): void
    {
        $this->bindings[$key] = $concrete;
    }

    public function has(string $key): bool
    {
        return isset($this->bindings[$key]);
    }

    public function get(string $key): object | string
    {
        if ($this->has($key)) {
            return $this->bindings[$key];
        }

        $instance = $this->resolve($key);
        $this->bind($key, $instance);
        return $instance;
    }

    /**
     * @throws ReflectionException
     */
    public function call(array $callable, array $args = []): mixed
    {
        [$instance, $method] = $callable;
        $reflection = new ReflectionMethod($instance, $method);

        $dependencies = $this->resolveDependencies($reflection->getParameters(), $args);

        return $reflection->invokeArgs($instance, $dependencies);
    }

    /**
     * @throws ReflectionException
     */
    private function resolve(string $key) : object | string
    {
        if (class_exists($key)) {
            $reflection = new ReflectionClass($key);
            
            if (!$reflection->isInstantiable()) {
                throw new RuntimeException("La classe $key n'est pas instantiable");
            }
            
            $constructor = $reflection->getConstructor();

            // Si le constructeur n'existe pas, on retourne une nouvelle instance de la classe
            if ($constructor === null) {
                return new $key();
            }

            $dependencies = $this->resolveDependencies($constructor->getParameters());
            
            return $reflection->newInstanceArgs($dependencies);
        }

        throw new RuntimeException("Service '$key' not found or cannot be resolved.");
    }

    /**
     * @param ReflectionParameter[] $parameters
     * @param array $args
     * @return array
     */
    private function resolveDependencies(array $parameters, array $args = []): array
    {
        $dependencies = [];
        
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();

            // Si le paramètre est dans les arguments, on l'ajoute
            if (array_key_exists($name, $args)) {
                $dependencies[] = $args[$name];
                continue;
            }

            $type = $parameter->getType();

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                    continue;
                }

                if ($parameter->allowsNull()) {
                    $dependencies[] = null;
                    continue;
                }

                throw new RuntimeException("Impossible de résoudre le paramètre $name");
            }

            $dependencies[] = $this->get($type->getName());
        }
        
        return $dependencies;
    }
}