<?php

namespace Rehark\Carbon\http\response\exception;

use Exception;

class InvalidResponseException extends Exception {

    public function __construct() {
        parent::__construct('Invalid response content !');

    }

}