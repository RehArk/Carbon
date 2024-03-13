<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\route\WebRoute;
use Rehark\Carbon\http\router\uri\WebUri;

class WebRouteTest extends TestCase {

    public function testConstruct() {
        $route = new WebRoute(new WebUri('/'), HTTPMethods::GET);
        $this->assertInstanceOf(WebRoute::class, $route);
    }

}