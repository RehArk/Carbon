<?php

namespace Rehark\Carbon\http\router\route;

use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\uri\WebUri;

class WebRoute extends AbstractRoute {

    public function __construct(WebUri $uri, HTTPMethods $httpMethod) {
        parent::__construct($uri, $httpMethod);
    }

}