<?php

namespace Rehark\Carbon\dependency_injection\exception;

use Exception;

class ClassOrInterfaceNotRegisterException extends Exception{

    public function __construct() {
        parent::__construct('Class or interface not registerException');
    }

}