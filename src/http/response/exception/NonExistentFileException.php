<?php

namespace Rehark\Carbon\http\response\exception;

use Exception;

class NonExistentFileException extends Exception {

    public function __construct() {
        parent::__construct('This file not existe !');
    }

}