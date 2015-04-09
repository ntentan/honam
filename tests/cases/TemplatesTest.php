<?php
class TemplatesTest extends PHPUnit_Framework_TestCase
{
    private $view;
    
    public function setUp() 
    {
        $this->view = new \ntentan\honam\View();
    }
    
    public function testTemplateLoading()
    {
        $this->view->setTemplate('main.tpl.php');
        $this->view->out("Cool");
    }
}
