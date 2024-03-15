<?php

namespace Rehark\Carbon\Test\utils;

use ReflectionClass;

class MethodsMocker {

    public static function getMethod(string $class,string $name) {
        $class = new ReflectionClass($class);
        $method = $class->getMethod($name);
        return $method;
    }

}