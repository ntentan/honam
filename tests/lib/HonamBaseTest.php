<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\template_engines\TemplateEngine;

class HonamBaseTest extends \PHPUnit_Framework_TestCase
{
    protected $view;
    
    public static function setUpBeforeClass() 
    {
        TemplateEngine::appendPath('tests/views');
    }    
    
    public function setUp() 
    {
        $this->view = new \ntentan\honam\View();
    }
    
    public static function tearDownAfterClass() 
    {
        TemplateEngine::reset();
    }
}
