<?php

namespace Rehark\Carbon\http\router\route;

use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\uri\DefinitionUri;

class DefinitionRoute extends AbstractRoute {

    public function __construct(DefinitionUri $uri, HTTPMethods $httpMethod) {
        parent::__construct($uri, $httpMethod);
    }

}