<?php

namespace Rehark\Carbon\http\response;

enum HttpCode : int {

    case HTTP_CONTINUE = 100;
    case HTTP_SWITCHING_PROTOCOLS = 101;
    case HTTP_PROCESSING = 102;
    case HTTP_EARLY_HINTS = 103;
    case HTTP_OK = 200;
    case HTTP_CREATED = 201;
    case HTTP_ACCEPTED = 202;
    case HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    case HTTP_NO_CONTENT = 204;
    case HTTP_RESET_CONTENT = 205;
    case HTTP_PARTIAL_CONTENT = 206;
    case HTTP_MULTI_STATUS = 207;
    case HTTP_ALREADY_REPORTED = 208;
    case HTTP_IM_USED = 226;
    case HTTP_MULTIPLE_CHOICES = 300;
    case HTTP_MOVED_PERMANENTLY = 301;
    case HTTP_FOUND = 302;
    case HTTP_SEE_OTHER = 303;
    case HTTP_NOT_MODIFIED = 304;
    case HTTP_TEMPORARY_REDIRECT = 307;
    case HTTP_PERMANENTLY_REDIRECT = 308;
    case HTTP_BAD_REQUEST = 400;
    case HTTP_UNAUTHORIZED = 401;
    case HTTP_PAYMENT_REQUIRED = 402;
    case HTTP_FORBIDDEN = 403;
    case HTTP_NOT_FOUND = 404;
    case HTTP_METHOD_NOT_ALLOWED = 405;
    case HTTP_NOT_ACCEPTABLE = 406;
    case HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    case HTTP_REQUEST_TIMEOUT = 408;
    case HTTP_CONFLICT = 409;
    case HTTP_GONE = 410;
    case HTTP_LENGTH_REQUIRED = 411;
    case HTTP_PRECONDITION_FAILED = 412;
    case HTTP_PAYLOAD_TOO_LARGE = 413;
    case HTTP_URI_TOO_LONG = 414;
    case HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    case HTTP_RANGE_NOT_SATISFIABLE = 416;
    case HTTP_EXPECTATION_FAILED = 417;
    case HTTP_I_AM_A_TEAPOT = 418;
    case HTTP_MISDIRECTED_REQUEST = 421;
    case HTTP_UNPROCESSABLE_ENTITY = 422;
    case HTTP_LOCKED = 423;
    case HTTP_FAILED_DEPENDENCY = 424;
    case HTTP_TOO_EARLY = 425;
    case HTTP_UPGRADE_REQUIRED = 426;
    case HTTP_PRECONDITION_REQUIRED = 428;
    case HTTP_TOO_MANY_REQUESTS = 429;
    case HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
    case HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    case HTTP_INTERNAL_SERVER_ERROR = 500;
    case HTTP_NOT_IMPLEMENTED = 501;
    case HTTP_BAD_GATEWAY = 502;
    case HTTP_SERVICE_UNAVAILABLE = 503;
    case HTTP_GATEWAY_TIMEOUT = 504;
    case HTTP_VERSION_NOT_SUPPORTED = 505;
    case HTTP_VARIANT_ALSO_NEGOTIATES = 506;
    case HTTP_INSUFFICIENT_STORAGE = 507;
    case HTTP_LOOP_DETECTED = 508;
    case HTTP_NOT_EXTENDED = 510;
    case HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

    public function message() : string {

        return match ($this) {
            self::HTTP_CONTINUE => '100 Continue',
            self::HTTP_SWITCHING_PROTOCOLS => '101 Switching Protocols',
            self::HTTP_PROCESSING => '102 Processing',
            self::HTTP_EARLY_HINTS => '103 Early Hints',
            self::HTTP_OK => '200 OK',
            self::HTTP_CREATED => '201 Created',
            self::HTTP_ACCEPTED => '202 Accepted',
            self::HTTP_NON_AUTHORITATIVE_INFORMATION => '203 Non-Authoritative Information',
            self::HTTP_NO_CONTENT => '204 No Content',
            self::HTTP_RESET_CONTENT => '205 Reset Content',
            self::HTTP_PARTIAL_CONTENT => '206 Partial Content',
            self::HTTP_MULTI_STATUS => '207 Multi-Status',
            self::HTTP_ALREADY_REPORTED => '208 Already Reported',
            self::HTTP_IM_USED => '226 IM Used',
            self::HTTP_MULTIPLE_CHOICES => '300 Multiple Choices',
            self::HTTP_MOVED_PERMANENTLY => '301 Moved Permanently',
            self::HTTP_FOUND => '302 Found',
            self::HTTP_SEE_OTHER => '303 See Other',
            self::HTTP_NOT_MODIFIED => '304 Not Modified',
            self::HTTP_TEMPORARY_REDIRECT => '307 Temporary Redirect',
            self::HTTP_PERMANENTLY_REDIRECT => '308 Permanent Redirect',
            self::HTTP_BAD_REQUEST => '400 Bad Request',
            self::HTTP_UNAUTHORIZED => '401 Unauthorized',
            self::HTTP_PAYMENT_REQUIRED => '402 Payment Required',
            self::HTTP_FORBIDDEN => '403 Forbidden',
            self::HTTP_NOT_FOUND => '404 Not Found',
            self::HTTP_METHOD_NOT_ALLOWED => '405 Method Not Allowed',
            self::HTTP_NOT_ACCEPTABLE => '406 Not Acceptable',
            self::HTTP_PROXY_AUTHENTICATION_REQUIRED => '407 Proxy Authentication Required',
            self::HTTP_REQUEST_TIMEOUT => '408 Request Timeout',
            self::HTTP_CONFLICT => '409 Conflict',
            self::HTTP_GONE => '410 Gone',
            self::HTTP_LENGTH_REQUIRED => '411 Length Required',
            self::HTTP_PRECONDITION_FAILED => '412 Precondition Failed',
            self::HTTP_PAYLOAD_TOO_LARGE => '413 Payload Too Large',
            self::HTTP_URI_TOO_LONG => '414 URI Too Long',
            self::HTTP_UNSUPPORTED_MEDIA_TYPE => '415 Unsupported Media Type',
            self::HTTP_RANGE_NOT_SATISFIABLE => '416 Range Not Satisfiable',
            self::HTTP_EXPECTATION_FAILED => '417 Expectation Failed',
            self::HTTP_I_AM_A_TEAPOT => '418 I\'m a teapot',
            self::HTTP_MISDIRECTED_REQUEST => '421 Misdirected Request',
            self::HTTP_UNPROCESSABLE_ENTITY => '422 Unprocessable Content',
            self::HTTP_LOCKED => '423 Locked',
            self::HTTP_FAILED_DEPENDENCY => '424 Failed Dependency',
            self::HTTP_TOO_EARLY => '425 Too Early',
            self::HTTP_UPGRADE_REQUIRED => '426 Upgrade Required',
            self::HTTP_PRECONDITION_REQUIRED => '428 Precondition Required',
            self::HTTP_TOO_MANY_REQUESTS => '429 Too Many Requests',
            self::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE => '431 Request Header Fields Too Large',
            self::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS => '451 Unavailable For Legal Reasons',
            self::HTTP_INTERNAL_SERVER_ERROR => '500 Internal Server Error',
            self::HTTP_NOT_IMPLEMENTED => '501 Not Implemented',
            self::HTTP_BAD_GATEWAY => '502 Bad Gateway',
            self::HTTP_SERVICE_UNAVAILABLE => '503 Service Unavailable',
            self::HTTP_GATEWAY_TIMEOUT => '504 Gateway Timeout',
            self::HTTP_VERSION_NOT_SUPPORTED => '505 HTTP Version Not Supported',
            self::HTTP_VARIANT_ALSO_NEGOTIATES => '506 Variant Also Negotiates',
            self::HTTP_INSUFFICIENT_STORAGE => '507 Insufficient Storage',
            self::HTTP_LOOP_DETECTED => '508 Loop Detected',
            self::HTTP_NOT_EXTENDED => '510 Not Extended',
            self::HTTP_NETWORK_AUTHENTICATION_REQUIRED => '511 Network Authentication Required'
        };

    }

}