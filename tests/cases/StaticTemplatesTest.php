<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\Templates;
use PHPUnit\Framework\TestCase;

class StaticTemplatesTest extends TestCase
{
    public function testRenderer()
    {
        $templates = Templates::getDefaultInstance();
        $this->assertInstanceOf(Templates::class, $templates);

    }
}