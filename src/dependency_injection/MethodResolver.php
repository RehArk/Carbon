<?php

namespace Rehark\Carbon\dependency_injection;

use ReflectionMethod;
use Rehark\Carbon\component\controller\AbstractController;
use Rehark\Carbon\dependency_injection\exception\DependencyNotRegisterException;

/**
 * Resolves and invokes methods on controller instances.
 * 
 * This class is responsible for resolving method parameters from the DI container 
 * and invoking methods on instances of controllers, ensuring that dependencies 
 * are properly injected.
 */
class MethodResolver
{

    /**
     * Invokes a method on the specified controller instance, resolving its parameters.
     * 
     * The method parameters are resolved using the DI container, and the method 
     * is called with the resolved parameters. Any additional arguments can also 
     * be provided.
     *
     * @param AbstractController $controllerInstance The instance of the controller.
     * @param string $methodName The name of the method to invoke.
     * @param array $args Additional arguments for the method, if needed.
     * 
     * @throws \ReflectionException If the specified method does not exist.
     * 
     * @return mixed The result returned by the invoked method.
     */
    public function resolve(AbstractController $controllerInstance, string $methodName, array $args = []): mixed
    {
        $container = Container::get();

        $reflectionMethod = new ReflectionMethod($controllerInstance, $methodName);
        $parameters = $reflectionMethod->getParameters();
        $args = $container->resolveParameters($parameters, $args);

        return $reflectionMethod->invokeArgs($controllerInstance, $args);
    }

}
