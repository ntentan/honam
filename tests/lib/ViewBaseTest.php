<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\TemplateEngine;
use PHPUnit\Framework\TestCase;

class ViewBaseTest extends  TestCase
{
    protected $view;
    
    public static function setUpBeforeClass() : void
    {
        TemplateEngine::appendPath('tests/files/views');
    }   
    
    public static function tearDownAfterClass() : void
    {
        TemplateEngine::reset();
    }
}
