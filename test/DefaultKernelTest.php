<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\DefaultKernel;
use Rehark\Carbon\Test\datasets\RouterDataset;

final class DefaultKernelTest extends TestCase
{    

    public function setUp() : void {
        RouterDataset::create(__DIR__);
    }

    public function tearDown() : void {
        RouterDataset::clear(__DIR__);
    }

    public function testConstructor(): void {
        $kernel = new DefaultKernel(__DIR__);
        $this->assertInstanceOf(DefaultKernel::class, $kernel);
    }
}