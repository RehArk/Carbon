<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\route\DefinitionRoute;
use Rehark\Carbon\http\router\uri\DefinitionUri;
use Rehark\Carbon\component\controller\DefaultController;

class DefinitionRouteTest extends TestCase {
    
    public function testConstruct() {
        $route = new DefinitionRoute(
            new DefinitionUri('/'), 
            HTTPMethods::GET,
            DefaultController::class,
            'serverStatus'
        );
        $this->assertInstanceOf(DefinitionRoute::class, $route);
    }

    public function testGetController() {
        $route = new DefinitionRoute(
            new DefinitionUri('/'), 
            HTTPMethods::GET,
            DefaultController::class,
            'serverStatus'
        );
        $this->assertEquals(DefaultController::class, $route->getController());
    }

    
    public function testGetClassMethod() {
        $route = new DefinitionRoute(
            new DefinitionUri('/'), 
            HTTPMethods::GET,
            DefaultController::class,
            'serverStatus'
        );
        $this->assertEquals('serverStatus', $route->getClassMethod());
    }

}