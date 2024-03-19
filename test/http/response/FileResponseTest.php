<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\response\exception\InvalidResponseException;
use Rehark\Carbon\http\response\exception\NonExistentFileException;
use Rehark\Carbon\http\response\http_code\HttpCode;
use Rehark\Carbon\http\response\FileResponse;
use Rehark\Carbon\http\response\Response;

class FileResponseTest extends TestCase {

    public function testConstructor() {

        $response = new FileResponse(__DIR__ . '/FileResponseTest.php');
        $this->assertEquals($response->getHttpCode(), HttpCode::from(200));
        $this->assertEquals($response->getContent(), file_get_contents(__DIR__ . '/FileResponseTest.php'));

        $this->expectException(NonExistentFileException::class);
        $response = new FileResponse(200, './not-existing-file');

    }

}