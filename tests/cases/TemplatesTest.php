<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\template_engines\TemplateEngine;
use org\bovigo\vfs\vfsStream;

class TemplatesTest extends \ntentan\honam\tests\lib\HonamBaseTest
{
    public function testTemplateLoading()
    {
        $this->view->setTemplate('hello.tpl.php');
        $this->view->setLayout('main.tpl.php');
        $output = $this->view->out(
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Layout says: Hello World! I am James Ainooson.", $output);
        
        TemplateEngine::prependPath("tests/views/secondary");
        $output = $this->view->out(
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Layout says: Hello World Again! I am James Ainooson.", $output);
        TemplateEngine::reset();
        TemplateEngine::appendPath('tests/views');
    }
    
    public function testSubPathTemplateLoading()
    {
        $this->view->setLayout(false);
        $this->view->setTemplate('some_login.tpl.php');
        $output = $this->view->out(array());
        $this->assertEquals("This is a Login Page?", $output);
        
        TemplateEngine::prependPath("tests/views/secondary");
        $output = $this->view->out(array());
        $this->assertEquals("Is this another Login Page?", $output);
        TemplateEngine::reset();
        TemplateEngine::appendPath('tests/views');
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\FileNotFoundException
     */
    public function testLayoutLoadFailure()
    {
        $this->view->setLayout('arbitrary.tpl.php');
        $this->view->out(array());
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\FileNotFoundException
     */
    public function testTemplateLoadFailure()
    {
        $this->view->setTemplate('arbitrary.tpl.php');
        $this->view->out(array());
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\TemplateEngineNotFoundException
     */    
    public function testEngineLoadFailure()
    {
        $this->view->setTemplate('arbitrary.tpl.noengine');
        $this->view->out(array());
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
    
    public function testAssetLoading()
    {
        vfsStream::setup('public');
        TemplateEngine::setAssetsBaseDir('tests/assets');
        TemplateEngine::setPublicBaseDir(vfsStream::url('public'));
        $this->view->setTemplate('assets.tpl.php');
        $output = $this->view->out(array());
        $this->assertEquals("vfs://public/some.css", $output);
        $this->assertFileExists($output);
    }
}
