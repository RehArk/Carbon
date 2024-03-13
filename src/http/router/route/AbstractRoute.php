<?php

namespace Rehark\Carbon\http\router\route;

use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\uri\AbstractUri;

/**
 * Abstract class representing a route.
 */
abstract class AbstractRoute {

    /**
     * The URI associated with the route.
     * @var AbstractUri
     */
    private AbstractUri $uri;

    /**
     * The HTTP method associated with the route.
     * @var HTTPMethods
     */
    private HTTPMethods $httpMethod;

    /**
     * Constructor for AbstractRoute.
     * @param AbstractUri $uri The URI for the route.
     * @param HTTPMethods $httpMethod The HTTP method for the route.
     */
    public function __construct(AbstractUri $uri, HTTPMethods $httpMethod) {
        $this->uri = $uri;
        $this->httpMethod = $httpMethod;
    }

    /**
     * Gets the URI associated with the route.
     * @return AbstractUri The URI object.
     */
    public function getUri() : AbstractUri {
        return $this->uri;
    }

    /**
     * Gets the HTTP method associated with the route.
     * @return HTTPMethods The HTTP method object.
     */
    public function getHttpMethod() : HTTPMethods {
        return $this->httpMethod;
    }

}