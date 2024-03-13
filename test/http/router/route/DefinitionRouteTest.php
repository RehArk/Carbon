<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\route\DefinitionRoute;
use Rehark\Carbon\http\router\uri\DefinitionUri;

class DefinitionRouteTest extends TestCase {
    
    public function testConstruct() {
        $route = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET);
        $this->assertInstanceOf(DefinitionRoute::class, $route);
    }

}