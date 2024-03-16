<?php

namespace Rehark\Carbon\http\router\route;

use Rehark\Carbon\component\controller\AbstractController;
use Rehark\Carbon\http\method\HTTPMethods;
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
}