<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\response\http_code\HttpCode;
use Rehark\Carbon\http\response\JsonResponse;

class JsonResponseTest extends TestCase {

    public function testConstructor() {

        $response = new JsonResponse(200, ['data' => ['data1', 'data2']]);
        $this->assertEquals($response->getHttpCode(), HttpCode::from(200));
        $this->assertEquals($response->getContent(), '{"data":["data1","data2"]}');

    }

}