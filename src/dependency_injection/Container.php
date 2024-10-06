<?php

namespace Rehark\Carbon\dependency_injection;

use ReflectionClass;
use ReflectionMethod;
use Rehark\Carbon\component\controller\AbstractController;
use Rehark\Carbon\dependency_injection\exception\DependencyNotRegisterException;

/**
 * Class Container
 *
 * This class represents a Dependency Injection (DI) container that handles the
 * registration and resolution of dependencies for classes and interfaces. 
 * It follows the Singleton design pattern to ensure a single instance of the container.
 */
class Container
{

    /**
     * @var Container Holds the single instance of the container (Singleton).
     */
    private static Container $container;

    /**
     * Gets the single instance of the Container.
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
     * @var array Holds all the registered dependencies.
     * Dependencies are stored in a multi-dimensional array categorized by 
     * their types: class, interface, or instance.
     */
    private array $dependencies = [];

    /**
     * Constructor
     * 
     * The constructor is private to enforce the Singleton pattern, preventing
     * direct instantiation of the class.
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
     * Registers a class, interface, or instance in the container.
     *
     * @param string $key The key representing the class, interface, or instance to register.
     * @param mixed $class The actual class or instance to associate with the key.
     */
    public function register(string $key, $class): void
    {
        $type = $this->defineType($key);
        $this->dependencies[$type][$key] = $class;
    }

    /**
     * Resolves the given dependency by its key, instantiating the class or
     * returning the instance if already register.
     *
     * @param string $key The key representing the dependency to resolve.
     * @param array $parameters Optional parameters for class instantiation.
     *
     * @throws DependencyNotRegisterException If the dependency is not registered.
     *
     * @return mixed The resolved class instance or value.
     */
    public function resolve(string $key, array $parameters = []): mixed
    {

        if (!$this->isExistingDependdency($key)) {
            throw new DependencyNotRegisterException();
        }

        if ($this->isExistingInstance($key)) {
            return $this->getValueOf($key);
        }

        $_key = $this->getDependencyClass($key, $parameters);
        return $this->build($_key, $parameters);
    }

    /**
     * Resolves method parameters using the container and calls the method on the controller instance.
     *
     * @param object $controllerInstance The controller instance.
     * @param string $methodName The method name to be called.
     * @param array $arg Additionnal arguments.
     * @return mixed The result of the method call.
     * @throws \ReflectionException If the method does not exist.
     */
    public function resolveMethod(AbstractController $controllerInstance, string $methodName, $args = []) : mixed {

        $reflectionMethod = new ReflectionMethod($controllerInstance, $methodName);
        $parameters = $reflectionMethod->getParameters();
        $args = $this->resolveParameters($parameters, $args);

        return $reflectionMethod->invokeArgs($controllerInstance, $args);

    }

    /**
     * Builds and resolves the dependencies for a given class.
     *
     * This method uses reflection to inspect the constructor of the class and
     * injects the required dependencies recursively.
     *
     * @param string $class The class to instantiate.
     * @param array $parameters Optional parameters for dependency resolution.
     *
     * @return mixed A new instance of the class with dependencies injected.
     */
    public function build($class, $args): object
    {

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }
        
        $dependencies = [];
        $parameters = $constructor->getParameters();
        $dependencies = $this->resolveParameters($parameters, $args);

        return $reflection->newInstanceArgs($dependencies);
    }

    public function resolveParameters(array $parameters, array $args) {

        $dependencies = [];

        foreach ($parameters as $key => $parameter) {

            $parameterType = $parameter->getType();
            $parameterName = $parameter->getName();

            $dependencyName = $parameterType->getName();

            $type = $this->defineType($parameterName);

            // if parameter is in parameters, add as dependency
            if (array_key_exists($dependencyName, $args)) {
                $dependencies[] = $args[$dependencyName];
                continue;
            }

            // if parameter is string, try to resolve by name
            if ($dependencyName == 'string' && $type == 'instance') {
                $dependencies[] = $this->resolve($parameterName);
                continue;
            }

            // if parameter is optionnal, set default value
            if ($parameter->isOptional()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            // else try to resolve
            $dependencies[] = $this->resolve($dependencyName);
        }

        return $dependencies;

    }

    /**
     * Determines the type of the dependency based on the key.
     * Returns 'class' if the key is a class, 'interface' if it's an interface,
     * and 'instance' if it's a specific instance.
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
    private function isExistingDependdency(string $key): bool
    {
        $type = $this->defineType($key);

        // If it's a class, it will implicitly be a dependency.
        if ($type == 'class') {
            return true;
        }

        return array_key_exists($key, $this->dependencies[$type]);
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
        return array_key_exists($key, $this->dependencies[$type]);
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

        if (!$this->isExistingDependdency($key)) {
            return false;
        }

        if (
            !class_exists($key) &&
            !interface_exists($key)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get the dependency class by checking if it's registered, resolving it if necessary.
     *
     * @param string $key The key of the dependency.
     * @param array $parameters Parameters to be passed if the dependency is a callable.
     * @return mixed The resolved dependency class or the original value.
     */
    protected function getDependencyClass($key, $parameters = [])
    {
        // Check if dependency is registered
        if ($this->isDependencyRegistered($key)) {

            // Get the value associated with the key
            $valueOfKey = $this->getValueOf($key);

            // If the value is callable, resolve it by passing the parameters
            if (is_callable($valueOfKey)) {
                return call_user_func($valueOfKey, $parameters);
            }

            // Return the resolved value
            return $valueOfKey;
        }

        // Return null or handle the case when the dependency is not registered
        return $key;
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
