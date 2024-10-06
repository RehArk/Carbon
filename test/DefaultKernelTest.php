<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\component\controller\DefaultController;
use Rehark\Carbon\DefaultKernel;
use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\response\Response;
use Rehark\Carbon\http\router\route\DefinitionRoute;
use Rehark\Carbon\http\router\Router;
use Rehark\Carbon\http\router\uri\DefinitionUri;
use Rehark\Carbon\Test\datasets\RouterDataset;
use Rehark\Carbon\Test\utils\MethodsMocker;

final class DefaultKernelTest extends TestCase
{

    public function setUp(): void
    {
        RouterDataset::create(__DIR__);
    }

    public function tearDown(): void
    {
        RouterDataset::clear(__DIR__);
    }

    public function testConstructor(): void
    {
        $router = new Router(__DIR__);
        $kernel = new DefaultKernel($router);
        $this->assertInstanceOf(DefaultKernel::class, $kernel);
    }

    public function testFormatRequestedUri(): void
    {

        $router = new Router(__DIR__);
        $kernel = new DefaultKernel($router);
        $this->assertInstanceOf(DefaultKernel::class, $kernel);
        ob_clean();

        $formatRequestedUri = MethodsMocker::getMethod(DefaultKernel::class, 'formatRequestedUri');
        $uri = $formatRequestedUri->invokeArgs($kernel, [null]);
        $this->assertEquals($uri, '/');

        $formatRequestedUri = MethodsMocker::getMethod(DefaultKernel::class, 'formatRequestedUri');
        $uri = $formatRequestedUri->invokeArgs($kernel, ['/']);
        $this->assertEquals($uri, '/');

        $formatRequestedUri = MethodsMocker::getMethod(DefaultKernel::class, 'formatRequestedUri');
        $uri = $formatRequestedUri->invokeArgs($kernel, ['/test']);
        $this->assertEquals($uri, '/test');

        $formatRequestedUri = MethodsMocker::getMethod(DefaultKernel::class, 'formatRequestedUri');
        $uri = $formatRequestedUri->invokeArgs($kernel, ['/test/']);
        $this->assertEquals($uri, '/test');
    }

    public function testbuildResponseWithFoundedRouteWithResponse()
    {

        $router = new Router(__DIR__);
        $kernel = new DefaultKernel($router);
        ob_clean();

        $buildResponse = MethodsMocker::getMethod(DefaultKernel::class, 'buildResponse');
        $route = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET, DefaultController::class, 'serverStatus');
        $response = $buildResponse->invokeArgs($kernel, [$route]);
        $this->assertInstanceOf(Response::class, $response);
        $this->expectOutputString('Server on at ' . (new DateTime())->format('Y-m-d H:i:s') . '.');
        $response->send();
    }

    public function testbuildResponseWithRouteWithNoResponse()
    {

        $router = new Router(__DIR__);
        $kernel = new DefaultKernel($router);
        ob_clean();

        $buildResponse = MethodsMocker::getMethod(DefaultKernel::class, 'buildResponse');
        $route = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET, DefaultController::class, 'emptyResponse');
        $response = $buildResponse->invokeArgs($kernel, [$route]);
        $this->assertInstanceOf(Response::class, $response);
        $this->expectOutputString('');
        $response->send();
    }

    public function testbuildResponseWithNotRoute()
    {

        $router = new Router(__DIR__);
        $kernel = new DefaultKernel($router);
        ob_clean();

        $buildResponse = MethodsMocker::getMethod(DefaultKernel::class, 'buildResponse');
        $route = null;
        $response = $buildResponse->invokeArgs($kernel, [$route]);
        $this->assertInstanceOf(Response::class, $response);
        $this->expectOutputString('Resource not found !');
        $response->send();
    }

    public function testbuildResponseWithRouteInvalidController()
    {

        $router = new Router(__DIR__);
        $kernel = new DefaultKernel($router);
        ob_clean();

        $buildResponse = MethodsMocker::getMethod(DefaultKernel::class, 'buildResponse');
        $route = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET, 'NotExistingController', 'emptyResponse');
        $response = $buildResponse->invokeArgs($kernel, [$route]);
        $this->assertInstanceOf(Response::class, $response);
        $this->expectOutputString('No class found !');
        $response->send();
    }

    public function testbuildResponseWithRouteInvalidMethod()
    {

        $router = new Router(__DIR__);
        $kernel = new DefaultKernel($router);
        ob_clean();

        $buildResponse = MethodsMocker::getMethod(DefaultKernel::class, 'buildResponse');
        $route = new DefinitionRoute(new DefinitionUri('/'), HTTPMethods::GET, DefaultController::class, 'notExistingMethod');
        $response = $buildResponse->invokeArgs($kernel, [$route]);
        $this->assertInstanceOf(Response::class, $response);
        $this->expectOutputString('No method found !');
        $response->send();
    }
}
