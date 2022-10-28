<?php

namespace Vayu;

class Container implements \Psr\Container\ContainerInterface
{
    private array $entries = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            if (is_callable($entry)) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable|string $concrete): void
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve(string $id)
    {
        // 1. Inspect the class that we are trying to get from the container
        $reflectionClass = new \ReflectionClass($id);

        if (!$reflectionClass->isInstantiable()) {
            throw new \Exception('Class "' . $id . '" is not instantiable');
        }

        // 2. Inspect the constructor of the class
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $id;
        }

        // 3. Inspect the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();

        if (!$parameters) {
            return new $id;
        }
        $dependencies = [];
        foreach ($parameters as $param):
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                continue;
                /*throw new \Exception(
                    'Failed to resolve class "' . $id . '" because param "' . $name . '" is missing a type hint'
                );*/
            }

            if ($type instanceof \ReflectionUnionType) {
                continue;
                /*throw new \Exception(
                    'Failed to resolve class "' . $id . '" because of union type for param "' . $name . '"'
                );*/
            }

            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                $dependencies[] = $this->get($type->getName());
            }

            /*throw new \Exception(
                'Failed to resolve class "' . $id . '" because invalid param "' . $name . '"'
            );*/
        endforeach;

        // 4. If the constructor parameter is a class then try to resolve that class using the container
       /* $dependencies = array_map(
            function (\ReflectionParameter $param) use ($id) {

            },
            $parameters
        );*/

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}