<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\TemplateEngine;

class ViewBaseTest extends \PHPUnit_Framework_TestCase
{
    protected $view;
    
    public static function setUpBeforeClass() 
    {
        TemplateEngine::appendPath('tests/files/views');
    }   
    
    public static function tearDownAfterClass() 
    {
        TemplateEngine::reset();
    }
}
