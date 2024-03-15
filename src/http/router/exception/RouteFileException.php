<?php

namespace Rehark\Carbon\http\router\exception;

use Exception;

class RouteFileException extends Exception {

    public function __construct() {
        parent::__construct('No route file is found');
    }

}