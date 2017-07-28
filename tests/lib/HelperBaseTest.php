<?php
namespace ntentan\honam\tests\lib;

use PHPUnit\Framework\TestCase;

class HelperBaseTest extends TestCase
{
    protected $helpers;
    
    public function setUp()
    {
        $this->helpers = new \ntentan\honam\HelpersLoader();
    }
}
