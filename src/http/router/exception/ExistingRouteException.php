<?php

namespace Rehark\Carbon\http\router\exception;

use Exception;

class ExistingRouteException extends Exception {

    public function __construct() {
        parent::__construct('Routes already exist.');
    }

}