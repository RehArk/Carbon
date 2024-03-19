<?php

namespace Rehark\Carbon;

use Rehark\Carbon\http\response\AbstractResponse;
use Rehark\Carbon\http\response\Response;
use Rehark\Carbon\http\router\route\DefinitionRoute;
use Rehark\Carbon\http\router\Router;

class DefaultKernel {

    private string $root;
    public Router $router;

    public function __construct(string $root) {
        $this->root = $root;
        $this->initRouter();
        $matching_route = $this->start();
        $server_resposne = $this->buildResponse($matching_route);
        $server_resposne->send();
    }

    private function initRouter() : void {
        $this->router = new Router($this->root);
    }

    private function start() : ?DefinitionRoute {

        $real_requested_uri = $this->formatRequestedUri($_SERVER["REDIRECT_URL"] ?? null);
        $request_method = $_SERVER["REQUEST_METHOD"] ?? 'GET';
        
        $matching_route = $this->router->start(
            $real_requested_uri,
            $request_method
        );

        return $matching_route;

    }

    private function formatRequestedUri(?string $uri) : string {

        if(!$uri) {
            return '/';
        }

        $uri = rtrim($uri, '/');

        if($uri) {
            return $uri;
        }

        return '/';

    }

    private function buildResponse(?DefinitionRoute $matching_route) : AbstractResponse {

        if(!$matching_route) {
            return new Response(404, 'Resource not found !');
        }

        $className = $matching_route->getController();
        $methodName = $matching_route->getClassMethod();

        if (!class_exists($className)) {
            return new Response(500, "No class found !");
        }

        if (!method_exists($className, $methodName)) {
            return new Response(500, "No method found !");
        }

        $controllerInstance = new $className();
        $response = $controllerInstance->$methodName();

        if($response) {
            return $response;
        }
        
        return new Response(200, '');
        
    }

}