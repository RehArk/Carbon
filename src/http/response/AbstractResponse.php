<?php

namespace Rehark\Carbon\http\response;

use Rehark\Carbon\http\response\exception\InvalidHttpCodeException;
use Rehark\Carbon\http\response\http_code\HttpCode;

abstract class AbstractResponse {

    /**
     * the current http version
     * @property string $version
     */
    protected string $version;

    /**
     * the current response code
     * @property HttpCode $http_code 
     */
    protected HttpCode $http_code;

    /**
     * the current response content
     * @static @property string $content
     */
    protected string $content;

    public function __construct(
        HttpCode|int $http_code,
        mixed $content
    ) {
        $this->version = '1.1';
        $this->http_code = $this->tryConvertCode($http_code);
        $this->setContent($content);
        $this->setHeader();
    }

    /**
     * @return HttpCode $http_code
     */
    public function getHttpCode() : HttpCode {
        return $this->http_code;
    }

    /**
     * @return string $content
     */
    public function getContent() : string {
        return $this->content;
    }

    /**
     * try convert int code to HttpCode else throw error
     * @param HttpCode|int $code
     * @return HttpCode $code
     */
    public function tryConvertCode(HttpCode|int $http_code) {

        if (!is_int($http_code)) {
            return $http_code;
        }

        try {
            return HttpCode::from($http_code);
        } catch (\Throwable $th) {
            throw new InvalidHttpCodeException($http_code);
        }

    }

    public abstract function setHeader() : self;
    public abstract function setContent(mixed $content) : self;

    /**
     * send the current response
     * @return void
     */
    public function send() : void {
        echo $this->getContent();
    }

}
