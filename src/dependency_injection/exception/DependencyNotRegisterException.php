<?php

namespace Rehark\Carbon\dependency_injection\exception;

use Exception;

class DependencyNotRegisterException extends Exception{

    public function __construct() {
        parent::__construct('Dependencie not register exception');
    }

}