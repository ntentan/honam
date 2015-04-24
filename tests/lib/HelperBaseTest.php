<?php
namespace ntentan\honam\tests\lib;

class HelperBaseTest extends \PHPUnit_Framework_TestCase
{
    protected $helpers;
    
    public function setUp()
    {
        $this->helpers = new \ntentan\honam\HelpersLoader();
    }
}
