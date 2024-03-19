<?php

namespace Rehark\Carbon\http\response\exception;

use Exception;

class InvalidHttpCodeException extends Exception{

    public function __construct(int $http_code) {
        parent::__construct('HTTP code ' . $http_code . ' not exist');
    }

}
