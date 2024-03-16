<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\response\exception\InvalidHttpCodeException;
use Rehark\Carbon\http\response\HttpCode;
use Rehark\Carbon\http\response\Response;

class ResponseTest extends TestCase {

    public function testConstructor() {

        $response = new Response(200, 'Success');
        $this->assertEquals($response->getHttpCode(), HttpCode::from(200));
        $this->assertEquals($response->getContent(), 'Success');

        $response = new Response(HttpCode::HTTP_OK, 'Success');
        $this->assertEquals($response->getHttpCode(), HttpCode::from(200));
        $this->assertEquals($response->getContent(), 'Success');

        $this->expectException(InvalidHttpCodeException::class);
        $response = new Response(1000, 'Fail');

    }

}