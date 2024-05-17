<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\dependency_injection\Container;
use Rehark\Carbon\dependency_injection\exception\ClassOrInterfaceNotRegisterException;
use Rehark\Carbon\dependency_injection\exception\UnknowTypeException;

class ContainerTest extends TestCase {

    public function testCreation() {
        $container = Container::get();
        $this->assertInstanceOf(Container::class, $container);
    }

    public function testRegisterWithEmptyDependencies() {

        $container = Container::get();
        $reflection = new ReflectionObject($container);

        $property = $reflection->getProperty('dependencies');
        $property->setAccessible(true);
        $dependencies = $property->getValue($container);

        $expected = [];
        $this->assertEquals($expected, $dependencies);

    }

    public function testRegisterWithDependenciesFail() {
    
        $container = Container::get();

        $this->expectException(UnknowTypeException::class);
        $container->register('string', stdClass::class);
        
    }

    public function testRegisterWithInterfaceDependencies() {
    
        $container = Container::get();
        $reflection = new ReflectionObject($container);

        $container->register(Stringable::class, stdClass::class);

        $property = $reflection->getProperty('dependencies');
        $property->setAccessible(true);
        $dependencies = $property->getValue($container);

        $expected = [
            'interface' => [Stringable::class => stdClass::class]
        ];

        $this->assertEquals($expected, $dependencies);
        
    }

    public function testRegisterWithClassDependencies() {
    
        $container = Container::get();
        $reflection = new ReflectionObject($container);

        $container->register(stdClass::class, stdClass::class);

        $property = $reflection->getProperty('dependencies');
        $property->setAccessible(true);
        $dependencies = $property->getValue($container);

        $expected = [
            'interface' => [Stringable::class => stdClass::class],
            'class' => [stdClass::class => stdClass::class]
        ];

        $this->assertEquals($expected, $dependencies);
        
    }

    public function testResolveWithDependenciesFail() {
    
        $container = Container::get();

        $this->expectException(ClassOrInterfaceNotRegisterException::class);
        $container->resolve(DateTimeInterface::class);
        
    }

    public function testResolveWithInterfaceDependencies() {
    
        $container = Container::get();
        $class = $container->resolve(Stringable::class);

        $this->assertInstanceOf(stdClass::class, $class);
        
    }

    public function testResolveWithClassDependencies() {
    
        $container = Container::get();
        $class = $container->resolve(stdClass::class);

        $this->assertInstanceOf(stdClass::class, $class);
        
    }

}