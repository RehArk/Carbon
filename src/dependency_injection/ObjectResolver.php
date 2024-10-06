<?php

namespace Rehark\Carbon\dependency_injection;

use ReflectionClass;
use Rehark\Carbon\dependency_injection\exception\DependencyNotRegisterException;

/**
 * Handles the resolution of dependencies for classes through the container.
 * 
 * This class provides a mechanism to resolve dependencies by retrieving them 
 * from the container and creating instances if necessary.
 */
class ObjectResolver
{

    /**
     * Resolves and returns an instance of the specified class.
     * 
     * If the class has not been registered, an exception is thrown. Optionally, 
     * parameters for instantiation can be provided.
     *
     * @param string $class The fully qualified class name to resolve.
     * @param array $parameters Optional instantiation parameters.
     * 
     * @throws DependencyNotRegisterException If the class is not registered in the container.
     * 
     * @return mixed An instance of the resolved class.
     */
    public function resolve(string $class, array $parameters = []): mixed
    {
        $container = Container::get();
        return $container->build($class, $parameters);
    }

}
