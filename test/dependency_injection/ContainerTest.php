<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\component\controller\DefaultController;
use Rehark\Carbon\dependency_injection\Container;
use Rehark\Carbon\dependency_injection\exception\DependencyNotRegisterException;
use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\route\WebRoute;
use Rehark\Carbon\http\router\Router;
use Rehark\Carbon\http\router\uri\WebUri;
use Rehark\Carbon\Test\utils\MethodsMocker;

class ContainerTest extends TestCase
{

    public function testCreation()
    {
        $container = Container::get();
        $this->assertInstanceOf(Container::class, $container);
    }

    public function testRegisterWithEmptyDependencies() {

        $container = Container::get();
        $reflection = new ReflectionObject($container);

        $property = $reflection->getProperty('dependencies');
        $property->setAccessible(true);
        $dependencies = $property->getValue($container);

        $expected = [
            'class' => [],
            'interface' => [],
            'instance' => []
        ];

        $this->assertEquals($expected, $dependencies);

    }

    public function testRegisterWithInterfaceDependencies() {

        $container = Container::get();
        $reflection = new ReflectionObject($container);

        $container->register(Stringable::class, stdClass::class);

        $property = $reflection->getProperty('dependencies');
        $property->setAccessible(true);
        $dependencies = $property->getValue($container);

        $expected = [
            'class' => [],
            'interface' => [Stringable::class => stdClass::class],
            'instance' => []
        ];

        $this->assertEquals($expected, $dependencies);

    }

    public function testRegisterWithClassDependencies()
    {

        $container = Container::get();
        $reflection = new ReflectionObject($container);

        $container->register(WebUri::class, new WebUri('/'));
        $container->register('route_path', __DIR__);

        $property = $reflection->getProperty('dependencies');
        $property->setAccessible(true);
        $dependencies = $property->getValue($container);

        $expected = [
            'interface' => [
                Stringable::class => stdClass::class
            ],
            'instance' => [
                'route_path' => __DIR__
            ],
            'class' => [
                WebUri::class => new WebUri('/')
            ]
        ];

        $this->assertEquals($expected, $dependencies);
    }

    public function testResolveWithDependenciesFail() {

        $container = Container::get();

        $this->expectException(DependencyNotRegisterException::class);
        
        $container->resolve(DateTimeInterface::class);

    }

    public function testResolveWithInterfaceDependencies() {

        $container = Container::get();

        $class = $container->resolve(Stringable::class);
        $this->assertInstanceOf(stdClass::class, $class);

    }

    public function testResolveWithNoParameter() {

        $container = Container::get();

        $class = $container->resolve(stdClass::class);
        $this->assertInstanceOf(stdClass::class, $class);

    }

    public function testResolveWithParameters() {

        $container = Container::get();

        $date = $container->resolve(DateTime::class, ['string' => 'today']);

        $webRoute = $container->resolve(WebRoute::class, [
            WebUri::class => new WebUri('/'),
            HTTPMethods::class => HTTPMethods::GET
        ]);

        $this->assertInstanceOf(DateTime::class, $date);
        $this->assertEquals(new DateTime('today'), $date);

        $this->assertInstanceOf(WebRoute::class, $webRoute);

    }

    public function testResolveWithStringDependency() {

        $container = Container::get();

        $class = $container->resolve(Router::class);
        $this->assertInstanceOf(Router::class, $class);

    }

    public function testResolveWithOptionalParameter() {

        $container = Container::get();

        $class = $container->resolve(DateTime::class);

        $this->assertInstanceOf(DateTime::class, $class);

    }

    public function testResolveWithRegisterDependencies() {

        $container = Container::get();

        $class = $container->resolve(DefaultController::class);

        $this->assertInstanceOf(DefaultController::class, $class);

    }

    public function testInstanceExiste() {

        $container = Container::get();
        $instanceExist = MethodsMocker::getMethod(Container::class, 'instanceExist');

        $container->register('date', new DateTime('today'));

        $this->assertEquals($instanceExist->invokeArgs($container, ['notExistingKey']), false);
        $this->assertEquals($instanceExist->invokeArgs($container, ['date']), true);

    }

}
