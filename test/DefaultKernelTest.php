<?php

use PHPUnit\Framework\TestCase;
use Rehark\Carbon\DefaultKernel;

final class DefaultKernelTest extends TestCase
{
    public function testConstructor(): void
    {
        $kernel = new DefaultKernel();
        $this->assertInstanceOf(DefaultKernel::class, $kernel);
    }
}