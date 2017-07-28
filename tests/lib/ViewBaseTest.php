<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\TemplateEngine;
use PHPUnit\Framework\TestCase;

class ViewBaseTest extends  TestCase
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
