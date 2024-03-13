<?php

namespace Rehark\Carbon\http\router\exception;

use Exception;

class InvalidUriException extends Exception {

    public function __construct() {
        parent::__construct('URI is not valid');
    }

}