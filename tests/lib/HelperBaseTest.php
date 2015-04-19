<?php
namespace ntentan\views\tests\lib;

class HelperBaseTest extends \PHPUnit_Framework_TestCase
{
    protected $helpers;
    
    public function setUp()
    {
        $this->helpers = new \ntentan\views\template_engines\HelpersLoader();
    }
}
