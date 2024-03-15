<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\http\router\RouteFileProvider;
use Rehark\Carbon\Test\datasets\RouterDataset;

class RouteFileProviderTest extends TestCase {

    public function setUp() : void {
        RouterDataset::create(__DIR__);
    }

    public function tearDown() : void {
        RouterDataset::clear(__DIR__);
    }

    public function testConstructor() {
        $route_file_provider = new RouteFileProvider(__DIR__);
        $this->assertInstanceOf(RouteFileProvider::class, $route_file_provider);
    }

}