<?php

namespace Rehark\Carbon\http\method;

Enum HTTPMethods : string {
    case GET = "GET";
    case POST = "POST";
    case PUT = "PUT";
    case DELETE = "DELETE";
    case PATCH = "PATCH";
    case HEAD = "HEAD";
    case OPTIONS = "OPTIONS";
    case CONNECT = "CONNECT";
    case TRACE = "TRACE";
}