<?php

namespace Rehark\Carbon\dependency_injection;

use ReflectionClass;
use Rehark\Carbon\dependency_injection\exception\DependencyNotRegisterException;

/**
 * Manages the registration and resolution of dependencies in a Dependency Injection (DI) system.
 * 
 * This class implements the Singleton pattern to ensure only one instance 
 * of the container exists, handling various types of dependencies: classes, 
 * interfaces, and instances.
 */
class Container
{

    /**
     * @var Container Holds the single instance of the container (Singleton).
     */
    private static Container $container;

    /**
     * Retrieves the singleton instance of the Container.
     * If the instance does not exist, it creates one.
     *
     * @return Container The single instance of the container.
     */
    public static function get(): Container
    {
        if (!isset(self::$container)) {
            self::$container = new Container();
        }

        return self::$container;
    }

    /**
     * @var array Holds all the registered dependencies, categorized by type: class, interface, or instance.
     */
    private array $dependencies = [];

    /**
     * Private constructor to enforce the Singleton pattern.
     */
    private function __construct()
    {
        $this->dependencies = [
            'class' => [],
            'interface' => [],
            'instance' => []
        ];
    }

    /**
     * Registers a dependency (class, interface, or instance) in the container.
     *
     * @param string $key The key representing the dependency to register.
     * @param mixed $class The actual class or instance to associate with the key.
     */
    public function register(string $key, mixed $class): void
    {
        $type = $this->defineType($key);
        $this->dependencies[$type][$key] = $class;
    }

    /**
     * Resolves and returns an instance of the given dependency.
     *
     * If the dependency is already instantiated, it returns that instance; 
     * otherwise, it creates a new instance using the DI container.
     *
     * @param string $key The key representing the dependency to resolve.
     * @param array $args Optional parameters for class instantiation.
     * 
     * @throws DependencyNotRegisterException If the dependency is not registered.
     * 
     * @return mixed The resolved class instance or value.
     */
    public function build(string $key, array $args = []): mixed
    {
        if ($this->isExistingInstance($key)) {
            return $this->getValueOf($key);
        }

        $class = $this->getDependencyClass($key, $args);
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $dependencies = $this->resolveParameters($constructor->getParameters(), $args);
        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * Resolves method parameters using the container.
     *
     * @param array $parameters The parameters of the method to resolve.
     * @param array $args Additional arguments provided for resolution.
     *
     * @return array Resolved dependencies for the method parameters.
     */
    public function resolveParameters(array $parameters, array $args): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $parameterType = $parameter->getType();
            $parameterName = $parameter->getName();
            $dependencyName = $parameterType->getName();

            // If parameter is in args, add as dependency
            if (isset($args[$dependencyName])) {
                $dependencies[] = $args[$dependencyName];
                continue;
            }

            // If parameter is string, try to resolve by name
            if ($dependencyName == 'string' && $this->defineType($parameterName) == 'instance') {
                $dependencies[] = $this->build($parameterName);
                continue;
            }

            // If parameter is optional, set default value
            if ($parameter->isOptional()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            // Else try to resolve the dependency
            $dependencies[] = $this->build($dependencyName);
        }

        return $dependencies;
    }

    /**
     * Determines the type of the dependency based on the key.
     *
     * @param string $key The key representing the dependency.
     *
     * @return string The type of the dependency ('class', 'interface', or 'instance').
     */
    private function defineType(string $key): string
    {
        if (class_exists($key)) {
            return 'class';
        }

        if (interface_exists($key)) {
            return 'interface';
        }

        return 'instance';
    }

    /**
     * Checks if a dependency is registered in the container.
     *
     * @param string $key The key representing the dependency.
     *
     * @return bool True if the dependency exists, false otherwise.
     */
    private function isDependencyRegistered(string $key): bool
    {
        $type = $this->defineType($key);
        return isset($this->dependencies[$type][$key]);
    }


    /**
     * Checks if a dependency is registered in the container.
     *
     * @param string $key The key representing the dependency.
     *
     * @return bool True if the dependency exists, false otherwise.
     */
    private function isExistingDependdency(string $key): bool
    {
        $type = $this->defineType($key);
        return $type === 'class' || isset($this->dependencies[$type][$key]);
    }

    /**
     * Checks if a given key represents an already instantiated instance.
     *
     * @param string $key The key representing the dependency.
     *
     * @return bool True if the dependency is an instance, false otherwise.
     */
    private function isExistingInstance(string $key): bool
    {
        return isset($this->dependencies['instance'][$key]);
    }

    /**
     * Gets the dependency class by checking if it's registered, resolving it if necessary.
     *
     * @param string $key The key of the dependency.
     * @param array $args Parameters to be passed if the dependency is a callable.
     *
     * @return mixed The resolved dependency class or the original value.
     *
     * @throws DependencyNotRegisterException If the dependency is not registered.
     */
    private function getDependencyClass(string $key, array $args = []): mixed
    {
        if (!$this->isExistingDependdency($key)) {
            throw new DependencyNotRegisterException();
        }

        if (!$this->isDependencyRegistered($key)) {
            return $key;
        }

        $value = $this->getValueOf($key);

        // If the value is a function to build object depending on params
        if (is_callable($value)) {
            return call_user_func($value, $args);
        }

        // Return the resolved value
        return $value;
    }

    /**
     * Retrieves the value of a registered dependency by its key.
     *
     * @param string $key The key representing the dependency.
     *
     * @return mixed The registered class, interface, or instance.
     */
    private function getValueOf(string $key): mixed
    {
        $type = $this->defineType($key);
        return $this->dependencies[$type][$key];
    }
}
