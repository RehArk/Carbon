<?php

namespace Rehark\Carbon\http\response;

class JsonResponse extends AbstractResponse {

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

        header('Content-Type: application/json; charset=utf-8');

        return $this;

    }

    /**
     * set the current content
     * @return self
     */
    public function setContent(mixed $content) : self {
        $this->content = json_encode($content);
        return $this;
    }

}
