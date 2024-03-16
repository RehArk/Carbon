<?php

namespace Rehark\Carbon\http\router\route;

use Rehark\Carbon\component\controller\AbstractController;
use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\exception\ExistingRouteException;
use Rehark\Carbon\http\router\uri\DefinitionUri;

class DefinitionRoute extends AbstractRoute {

    private string $controller;
    private string $classMethod;

    public function __construct(
        DefinitionUri $uri, 
        HTTPMethods $httpMethod,
        string $controller,
        string $classMethod
    ) {
        parent::__construct($uri, $httpMethod);
        $this->controller = $controller;
        $this->classMethod = $classMethod;
    }

    public function getController() : string {
        return $this->controller;
    }

    public function getClassMethod() : string {
        return $this->classMethod;
    }

    /**
     * Compares two routes based on their URIs.
     * @param DefinitionRoute $routeA First route to compare.
     * @param DefinitionRoute $routeB Second route to compare.
     * @return int The result of comparison.
     * @throws ExistingRouteException If two routes have the same URI.
     */
    public function compare(DefinitionRoute $comparedRoute) {

        $uriA = $this->getUniqueUri();
        $uriB = $comparedRoute->getUniqueUri();

        $cmp = strcmp($uriA, $uriB);

        if ($cmp == 0) {
            throw new ExistingRouteException();
        }

        return $cmp;

    }

    /**
     * Removes content inside braces from a string.
     * @param string $string The string from which to remove braces.
     * @return array|string|null The string with braces removed.
     */
    private function getUniqueUri() {
        return preg_replace('/\{.*?\}/', '{}', $this->getUri()->string);
    }

}