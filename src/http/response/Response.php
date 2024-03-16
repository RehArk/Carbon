<?php

namespace Rehark\Carbon\http\response;

use Exception;
use Rehark\Carbon\http\response\exception\InvalidHttpCodeException;

class Response {

    /**
     * the current http version
     * @property string $version
     */
    private string $version;

    /**
     * the current response code
     * @property HttpCode $http_code 
     */
    private HttpCode $http_code;

    /**
     * the current response content
     * @static @property string $content
     */
    private string $content;

    public function __construct(
        HttpCode|int $http_code,
        string $content
    ) {
        $this->version = '1.1';
        $this->http_code = $this->tryConvertCode($http_code);
        $this->content = $content;
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

    /**
     * send the current header
     * @return self $this
     */
    public function sendHeader() : self {
        
        header(
            'HTTP/' . $this->version . ' ' . $this->http_code->value . ' ' . $this->http_code->message(), 
            true, 
            $this->http_code->value
        );

        header('Content-Type: text/html; charset=utf-8');

        return $this;

    }

    /**
     * send the current content
     * @return self $this
     */
    public function sendContent(): self {
        echo $this->content;
        return $this;
    }

    /**
     * send the current response
     * @return void
     */
    public function send() : void {
        
        $this
            ->sendHeader()
            ->sendContent()
        ;

    }

}