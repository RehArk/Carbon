<?php

namespace Rehark\Carbon\dependency_injection\exception;

use Exception;

class UnknowTypeException extends Exception{

    public function __construct() {
        parent::__construct('Unknow type exception : container key must be an interface or a class');
    }

}