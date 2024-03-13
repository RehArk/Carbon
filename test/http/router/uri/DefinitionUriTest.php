<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\router\exception\InvalidUriException;
use Rehark\Carbon\http\router\uri\DefinitionUri;

final class DefinitionUriTest extends TestCase {

    public function testConstructor(): void {

        $uri = new DefinitionUri('/route');
        $this->assertInstanceOf(DefinitionUri::class, $uri);
        $this->assertEquals($uri->getString(), '/route');


        $uri = new DefinitionUri('/Route');
        $this->assertInstanceOf(DefinitionUri::class, $uri);
        $this->assertEquals($uri->getString(), '/route');

        $this->expectException(InvalidUriException::class);
        new DefinitionUri('route');

    }

    public function testIsValid() {
        $uri = new DefinitionUri('/');
        $this->assertTrue($uri->isValid('/'));
        $this->assertTrue($uri->isValid('/route'));
        $this->assertTrue($uri->isValid('/{param}'));
        $this->assertTrue($uri->isValid('/route/route-2'));
        $this->assertTrue($uri->isValid('/route/{param}'));
        $this->assertTrue($uri->isValid('/route/pre-{param}'));
        $this->assertTrue($uri->isValid('/route/{param}-last'));
        $this->assertTrue($uri->isValid('/route/pre-{param}-last'));
    }

    public function testIsNotValid() {
        $uri = new DefinitionUri('/');
        $this->assertFalse($uri->isValid('route'));
        $this->assertFalse($uri->isValid('route/'));
        $this->assertFalse($uri->isValid('route/route/'));
        $this->assertFalse($uri->isValid('route//route'));
        $this->assertFalse($uri->isValid('route//route//route'));
        $this->assertFalse($uri->isValid('///'));
        $this->assertFalse($uri->isValid('//'));
    }

}