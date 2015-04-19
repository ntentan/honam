<?php
namespace ntentan\views\tests\lib;

use ntentan\views\template_engines\TemplateEngine;

class ViewBaseTest extends \PHPUnit_Framework_TestCase
{
    protected $view;
    
    public static function setUpBeforeClass() 
    {
        TemplateEngine::appendPath('tests/files/views');
    }    
    
    public function setUp() 
    {
        $this->view = new \ntentan\views\View();
    }
    
    public static function tearDownAfterClass() 
    {
        TemplateEngine::reset();
    }
}
