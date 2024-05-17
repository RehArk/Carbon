<?php

namespace Rehark\Carbon\dependency_injection;

use Rehark\Carbon\dependency_injection\exception\ClassOrInterfaceNotRegisterException;
use Rehark\Carbon\dependency_injection\exception\UnknowTypeException;

class Container {

    private static Container $container;

    public static function get() : Container {

        if(!isset(self::$container)) {
            self::$container = new Container();
        }

        return self::$container;

    }

    private array $dependencies = [];

    private function __construct() {}

    public function register(string $key, $class) {
        $type = $this->defineType($key);
        $this->dependencies[$type][$key] = $class;
    }

    public function resolve(string $key) {

        $type = $this->defineType($key);

        if(!array_key_exists($key, $this->dependencies[$type])) {
            throw new ClassOrInterfaceNotRegisterException();
        }

        return $this->build($this->dependencies[$type][$key]);

    }

    public function build($class) {
        return new $class();
    }

    private function defineType($key) : string {

        if(class_exists($key)) {
            return 'class';
        }

        if(interface_exists($key)) {
            return 'interface';
        }

        return throw new UnknowTypeException();;

    }

}