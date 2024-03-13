<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\router\exception\InvalidUriException;
use Rehark\Carbon\http\router\uri\WebUri;

final class WebUriTest extends TestCase {

    public function testConstructor(): void {

        $uri = new WebUri('/route');
        $this->assertInstanceOf(WebUri::class, $uri);

        $this->expectException(InvalidUriException::class);
        new WebUri('route');

    }

    public function testIsValid() {
        $uri = new WebUri('/');
        $this->assertTrue($uri->isValid('/'));
        $this->assertTrue($uri->isValid('/route'));
        $this->assertTrue($uri->isValid('/param'));
        $this->assertTrue($uri->isValid('/route/route-2'));
        $this->assertTrue($uri->isValid('/route/param'));
        $this->assertTrue($uri->isValid('/route/pre-param'));
        $this->assertTrue($uri->isValid('/route/param-last'));
        $this->assertTrue($uri->isValid('/route/pre-param-last'));
    }

    public function testIsNotValid() {
        $uri = new WebUri('/');
        $this->assertFalse($uri->isValid('route'));
        $this->assertFalse($uri->isValid('route/'));
        $this->assertFalse($uri->isValid('route/route/'));
        $this->assertFalse($uri->isValid('route//route'));
        $this->assertFalse($uri->isValid('route//route//route'));
        $this->assertFalse($uri->isValid('///'));
        $this->assertFalse($uri->isValid('//'));
        $this->assertFalse($uri->isValid('/{param}'));
        $this->assertFalse($uri->isValid('/route/{param}'));
        $this->assertFalse($uri->isValid('/route/pre-{param}'));
        $this->assertFalse($uri->isValid('/route/{param}-last'));
        $this->assertFalse($uri->isValid('/route/pre-{param}-last'));
    }
    
}