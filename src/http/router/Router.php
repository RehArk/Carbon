<?php

namespace Rehark\Carbon\http\router;

use Rehark\Carbon\http\router\exception\ExistingRouteException;
use Rehark\Carbon\http\router\route\DefinitionRoute;
use Rehark\Carbon\http\router\route\WebRoute;
use Rehark\Carbon\http\router\uri\DefinitionUri;
use Rehark\Carbon\http\router\uri\WebUri;

class Router {

    /**
     * Array to store routes grouped by HTTP methods.
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
        'PATCH' => [],
        'HEAD' => [],
        'OPTIONS' => [],
        'CONNECT' => [],
        'TRACE' => [],
    ];

    /**
     * Adds a route to the routes array.
     * @param DefinitionRoute $route The route to be added.
     * @return void
     */
    public function addRoute(DefinitionRoute $route) : void {
        $httpMethod = $route->getHttpMethod();
        $this->routes[$httpMethod->value][] = $route;
    }

    /**
     * Compares two routes based on their URIs.
     * @param DefinitionRoute $routeA First route to compare.
     * @param DefinitionRoute $routeB Second route to compare.
     * @return int The result of comparison.
     * @throws ExistingRouteException If two routes have the same URI.
     */
    private function compareRoutes(DefinitionRoute $routeA, DefinitionRoute $routeB) : int {

        $uriA = $this->removeBraceContent($routeA->getUri()->string);
        $uriB = $this->removeBraceContent($routeB->getUri()->string);

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
    private function removeBraceContent($string) : array|string|null {
        return preg_replace('/\{.*?\}/', '{}', $string);
    }

    /**
     * Sorts routes array based on their URIs.
     * @return void
     */
    public function sort() : void {
        foreach ($this->routes as $verb => $routes) {
            usort($this->routes[$verb], array($this, 'compareRoutes'));
        }
    }

    /**
     * Finds a route that matches the provided web route.
     * @param WebRoute $webRoute The web route to find a match for.
     * @return DefinitionRoute|null The matching route if found, otherwise null.
     */
    public function findRoute(WebRoute $webRoute)  : ?DefinitionRoute {

        $webUri = $webRoute->getUri();
        $httpMethod = $webRoute->getHttpMethod();

        foreach ($this->routes[$httpMethod->value] as $definitionRoute) {

            $definitionUri = $definitionRoute->getUri();

            if ($this->matchRoutes($webUri, $definitionUri)) {
                return $definitionRoute;
            }
        }

        return null;
    }

    /**
     * Matches web URI against a definition URI using regular expressions.
     * @param WebUri $webUri The web URI to match.
     * @param DefinitionUri $definitionUri The definition URI to match against.
     * @return int|false The result of the match operation.
     */
    private function matchRoutes(WebUri $webUri, DefinitionUri $definitionUri) : int|false {

        $pattern = preg_replace_callback('/\{.*?\}/', function ($matches) {
            return '([^\/]+)';
        }, $definitionUri->string);

        $regex = '#^' . $pattern . '$#';
        return preg_match($regex, $webUri->string);
    }

}