<?php
use ntentan\honam\template_engines\TemplateEngine;

class TemplatesTest extends PHPUnit_Framework_TestCase
{
    private $view;
    
    public static function setUpBeforeClass() 
    {
        TemplateEngine::appendPath('tests/views');
    }
    
    public function setUp() 
    {
        $this->view = new \ntentan\honam\View();
    }
    
    public function testTemplateLoading()
    {
        
        $this->view->setTemplate('hello.tpl.php');
        $this->view->setLayout('main.tpl.php');
        $output = $this->view->out(
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Layout says: Hello World! I am James Ainooson.", $output);
    }
     
    public function testLayoutExclusion()
    {
        $this->view->setTemplate('hello.tpl.php');
        $this->view->setLayout(false);
        $output = $this->view->out(
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Hello World! I am James Ainooson.", $output);
    }
        
    public function testTemplateExclusion()
    {
        $this->view->setTemplate(false);
        $this->view->setLayout('main.tpl.php');
        $output = $this->view->out(
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Layout says: ", $output);
    }
}
