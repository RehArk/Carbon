<?php

namespace Rehark\Carbon\http\response;

use Rehark\Carbon\http\response\exception\NonExistentFileException;
use Rehark\Carbon\http\response\http_code\HttpCode;

class FileResponse extends AbstractResponse {

    private string $path;

    public function __construct(mixed $path) {
        
        if (!file_exists($path)) {
            throw new NonExistentFileException();
        }

        $this->path = $path;

        parent::__construct(HttpCode::HTTP_OK, $path);

    }

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

        header('Content-Type: application/octet-stream');
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Disposition: attachment; filename="'.$this->path.'"');
        header('Content-Length: ' . strlen($this->getContent()), false);

        return $this;

    }

    /**
     * set the current content
     * @return self
     */
    public function setContent(mixed $path) : self {
        $this->content = file_get_contents($path);
        return $this;
    }

}