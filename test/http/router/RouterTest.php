<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\exception\ExistingRouteException;
use Rehark\Carbon\http\router\exception\RouteFileException;
use Rehark\Carbon\http\router\route\DefinitionRoute;
use Rehark\Carbon\http\router\route\WebRoute;
use Rehark\Carbon\http\router\Router;
use Rehark\Carbon\http\router\uri\DefinitionUri;
use Rehark\Carbon\http\router\uri\WebUri;
use Rehark\Carbon\Test\datasets\RouterDataset;
use Rehark\Carbon\Test\utils\MethodsMocker;

final class RouterTest extends TestCase
{

    public function setUp() : void {
        RouterDataset::create(__DIR__);
    }

    public function tearDown() : void {
        RouterDataset::clear(__DIR__);
    }

    protected static function removeDirectory($path) {

        $files = glob($path . '/*');

        foreach ($files as $file) {
            is_dir($file) ? Self::removeDirectory($file) : unlink($file);
        }

        rmdir($path);
    
    }
    
    public function testConstructor(): void {
        $router = new Router(__DIR__);
        $this->assertInstanceOf(Router::class, $router);
    }

    public function testLoadRoute() {
        $router = new Router(__DIR__);
        $loadRoute = MethodsMocker::getMethod(Router::class, 'loadRoute');
        $loadRoute->invokeArgs($router, []);
        $this->assertEquals(sizeof($router->getRoutes()["GET"]), 2);
    }

    public function testLoad() {
        $router = new Router(__DIR__);
        $load = MethodsMocker::getMethod(Router::class, 'load');
        $this->expectException(RouteFileException::class);
        $load->invokeArgs($router, ["not/existing/path"]);
    }
    
    public function testAddRoute() {

        $router = new Router(__DIR__);

        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::PUT));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::DELETE));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::PATCH));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::HEAD));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::OPTIONS));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::CONNECT));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::TRACE));

        foreach($router->getRoutes() as $httpRoutes) {
            $this->assertInstanceOf(DefinitionRoute::class, $httpRoutes[0]);
        }

    }

    public function testCompareRoutes() {

        $router = new Router(__DIR__);
        $compareRoutes = MethodsMocker::getMethod(Router::class, 'compareRoutes');
        
        $route1 = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET);
        $route2 = new DefinitionRoute(new DefinitionUri('/test'), HTTPMethods::GET);

        $this->assertEquals($compareRoutes->invokeArgs($router, [$route1, $route2]), -1);
        $this->assertEquals($compareRoutes->invokeArgs($router, [$route2, $route1]), 1);

        $route1 = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET);
        $route2 = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET);

        $this->expectException(ExistingRouteException::class);
        $compareRoutes->invokeArgs($router, [$route2, $route1]);

    }
    
    public function testRemoveBraceContent() {

        $router = new Router(__DIR__);
        $removeBraceContent = MethodsMocker::getMethod(Router::class, 'removeBraceContent');
        
        $this->assertEquals($removeBraceContent->invokeArgs($router, ["{aaa}"]), "{}");
        $this->assertEquals($removeBraceContent->invokeArgs($router, ["aaa-{aaa}"]), "aaa-{}");
        $this->assertEquals($removeBraceContent->invokeArgs($router, ["aaa-{aaa}-aaa"]), "aaa-{}-aaa");
        $this->assertEquals($removeBraceContent->invokeArgs($router, ["{aaa}-aaa"]), "{}-aaa");

    }

    public function testSort() {

        $router = new Router(__DIR__);

        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/new-route'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/route'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/route/{param}'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/check'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/get'), HTTPMethods::GET));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/{other-param}'), HTTPMethods::GET));
        $router->sort();

        $expectation = [
            new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET),
            new DefinitionRoute(new DefinitionUri('/new-route'), HTTPMethods::GET),
            new DefinitionRoute(new DefinitionUri('/route'), HTTPMethods::GET),
            new DefinitionRoute(new DefinitionUri('/route/{param}'), HTTPMethods::GET),
            new DefinitionRoute(new DefinitionUri('/{param}'), HTTPMethods::GET),
            new DefinitionRoute(new DefinitionUri('/{param}/check'), HTTPMethods::GET),
            new DefinitionRoute(new DefinitionUri('/{param}/get'), HTTPMethods::GET),
            new DefinitionRoute(new DefinitionUri('/{param}/{other-param}'), HTTPMethods::GET)
        ];

        $this->assertEquals($router->getRoutes()["GET"], $expectation);

        $router = new Router(__DIR__);

        $router->addRoute(new DefinitionRoute(new DefinitionUri('/route/{param}'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/new-route'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/check'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/route'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/post'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/{other-param}'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::POST));
        $router->sort();

        $expectation = [
            new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::POST),
            new DefinitionRoute(new DefinitionUri('/new-route'), HTTPMethods::POST),
            new DefinitionRoute(new DefinitionUri('/route'), HTTPMethods::POST),
            new DefinitionRoute(new DefinitionUri('/route/{param}'), HTTPMethods::POST),
            new DefinitionRoute(new DefinitionUri('/{param}'), HTTPMethods::POST),
            new DefinitionRoute(new DefinitionUri('/{param}/check'), HTTPMethods::POST),
            new DefinitionRoute(new DefinitionUri('/{param}/post'), HTTPMethods::POST),
            new DefinitionRoute(new DefinitionUri('/{param}/{other-param}'), HTTPMethods::POST)
        ];

        $this->assertEquals($router->getRoutes()["POST"], $expectation);

        $router = new Router(__DIR__);

        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::PUT));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::PUT));

        $this->expectException(ExistingRouteException::class);
        $router->sort();

        $router = new Router(__DIR__);

        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param-a}'), HTTPMethods::PUT));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param-b}'), HTTPMethods::PUT));

        $this->expectException(ExistingRouteException::class);
        $router->sort();

    }

    public function testMatchRoutes() {

        $router = new Router(__DIR__);
        $matchRoutes = MethodsMocker::getMethod(Router::class, 'matchRoutes');

        $webRoute1 = new WebRoute(new WebUri('/'), HTTPMethods::POST);
        $defintionRoute1 = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::POST);

        $webRoute2 = new WebRoute(new WebUri('/param'), HTTPMethods::POST);
        $defintionRoute2 = new DefinitionRoute(new DefinitionUri('/{param}'), HTTPMethods::POST);

        $webRoute3 = new WebRoute(new WebUri('/test-1'), HTTPMethods::POST);
        $defintionRoute3 = new DefinitionRoute(new DefinitionUri('/test-{number}'), HTTPMethods::POST);
        
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute1->getUri(), $defintionRoute1->getUri()]), 1);
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute1->getUri(), $defintionRoute2->getUri()]), 0);
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute1->getUri(), $defintionRoute3->getUri()]), 0);
        
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute2->getUri(), $defintionRoute1->getUri()]), 0);
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute2->getUri(), $defintionRoute2->getUri()]), 1);
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute2->getUri(), $defintionRoute3->getUri()]), 0);

        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute3->getUri(), $defintionRoute1->getUri()]), 0);
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute3->getUri(), $defintionRoute2->getUri()]), 1);
        $this->assertEquals($matchRoutes->invokeArgs($router, [$webRoute3->getUri(), $defintionRoute3->getUri()]), 1);

    }
    
    public function testFindRoute() {

        $router = new Router(__DIR__);
        $findRoute = MethodsMocker::getMethod(Router::class, 'findRoute');

        $router->addRoute(new DefinitionRoute(new DefinitionUri('/route/{param}'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/new-route'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/check'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/route'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/post'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/{param}/{other-param}'), HTTPMethods::POST));
        $router->addRoute(new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::POST));

        $router->sort();

        $webRoute1 = new WebRoute(new WebUri('/'), HTTPMethods::POST);
        $expectation1 = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::POST);

        $webRoute2 = new WebRoute(new WebUri('/new-route'), HTTPMethods::POST);
        $expectation2 = new DefinitionRoute(new DefinitionUri('/new-route'), HTTPMethods::POST);

        $webRoute3 = new WebRoute(new WebUri('/test-param'), HTTPMethods::POST);
        $expectation3 = new DefinitionRoute(new DefinitionUri('/{param}'), HTTPMethods::POST);

        $webRoute4 = new WebRoute(new WebUri('/test-param/test-parme'), HTTPMethods::POST);
        $expectation4 = new DefinitionRoute(new DefinitionUri('/{param}/{other-param}'), HTTPMethods::POST);

        $webRoute5 = new WebRoute(new WebUri('/it/test/not-found'), HTTPMethods::POST);
        $expectation5 = null;

        $this->assertEquals($findRoute->invokeArgs($router, [$webRoute1]), $expectation1);
        $this->assertEquals($findRoute->invokeArgs($router, [$webRoute2]), $expectation2);
        $this->assertEquals($findRoute->invokeArgs($router, [$webRoute3]), $expectation3);
        $this->assertEquals($findRoute->invokeArgs($router, [$webRoute4]), $expectation4);
        $this->assertEquals($findRoute->invokeArgs($router, [$webRoute5]), $expectation5);

    }

}