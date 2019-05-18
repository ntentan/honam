<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\engines\php\HelpersLoader;
use PHPUnit\Framework\TestCase;

class HelperBaseTest extends TestCase
{
    protected $helpers;
    
    public function setUp() : void
    {
        $this->helpers = new HelpersLoader();
    }
}
