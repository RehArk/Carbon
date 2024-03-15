<?php

namespace Rehark\Carbon;

use Rehark\Carbon\http\router\Router;

class DefaultKernel {

    private string $root;
    public Router $router;

    public function __construct(string $root) {
        $this->root = $root;
        $this->initRouter();
        $this->start();
    }

    private function initRouter() {
        $this->router = new Router($this->root);
    }

    private function start() {

        $real_requested_uri = $_SERVER["REDIRECT_URL"] ?? '/';
        $request_method = $_SERVER["REQUEST_METHOD"] ?? 'GET';
        
        $matching_route = $this->router->start(
            $real_requested_uri,
            $request_method
        );

    }

}