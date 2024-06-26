<?php

namespace Rehark\Carbon\http\response;

use Rehark\Carbon\http\response\exception\InvalidResponseException;

class Response extends AbstractResponse {

    /**
     * set the current header
     * @return self $this
     */
    public function setHeader() : self {
        
        header(
            'HTTP/' . $this->version . ' ' . $this->http_code->message(), 
            true, 
            $this->http_code->value
        );

        header('Content-Type: text/html; charset=utf-8');

        return $this;

    }

    /**
     * set the current content
     * @return self
     */
    public function setContent(mixed $content) : self {

        if(gettype($content) != "string") {
            throw new InvalidResponseException();
        }

        $this->content = $content;
        return $this;

    }

}