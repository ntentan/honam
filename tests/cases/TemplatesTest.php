<?php
namespace ntentan\views\tests\cases;

use ntentan\views\template_engines\TemplateEngine;
use ntentan\views\template_engines\AssetsLoader;

use org\bovigo\vfs\vfsStream;

class TemplatesTest extends \ntentan\views\tests\lib\ViewBaseTest
{
    public function testTemplateLoading()
    {
        $this->view->setTemplate('hello.tpl.php');
        $this->view->setLayout('main.tpl.php');
        $output = $this->view->out(
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Layout says: Hello World! I am James Ainooson.", $output);
        
        TemplateEngine::prependPath("tests/files/views/secondary");
        $output = $this->view->out(
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Layout says: Hello World Again! I am James Ainooson.", $output);
        TemplateEngine::reset();
        TemplateEngine::appendPath('tests/files/views');
    }
    
    public function testSubPathTemplateLoading()
    {
        $this->view->setLayout(false);
        $this->view->setTemplate('some_login.tpl.php');
        $output = $this->view->out(array());
        $this->assertEquals("This is a Login Page?", $output);
        
        TemplateEngine::prependPath("tests/files/views/secondary");
        $output = $this->view->out(array());
        $this->assertEquals("Is this another Login Page?", $output);
        TemplateEngine::reset();
        TemplateEngine::appendPath('tests/files/views');
    }
    
    /**
     * @expectedException \ntentan\views\exceptions\FileNotFoundException
     */
    public function testLayoutLoadFailure()
    {
        $this->view->setLayout('arbitrary.tpl.php');
        $this->view->out(array());
    }
    
    /**
     * @expectedException \ntentan\views\exceptions\FileNotFoundException
     */
    public function testTemplateLoadFailure()
    {
        $this->view->setTemplate('arbitrary.tpl.php');
        $this->view->out(array());
    }
    
    /**
     * @expectedException \ntentan\views\exceptions\TemplateEngineNotFoundException
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
    
    /**
     * @expectedException \ntentan\views\exceptions\FileNotFoundException
     */
    public function testAssetFileException()
    {
        vfsStream::setup('public');
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));   
        $this->view->setTemplate('missing_asset.tpl.php');
        $this->view->out(array());
    }    

    /**
     * @expectedException \ntentan\views\exceptions\FilePermissionException
     */
    public function testPublicDirectoryException()
    {
        vfsStream::setup('public', 0444);
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));   
        $this->view->setTemplate('assets.tpl.php');
        $this->view->out(array());
    }        
    
    public function testAssetLoading()
    {
        vfsStream::setup('public');
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));
        touch(vfsStream::url('public/existing.css'));
        
        $this->view->setTemplate('assets.tpl.php');
        $output = $this->view->out(array());
        $this->assertEquals("vfs://public/some.css\nvfs://public/another.css\nvfs://public/existing.css", $output);
        $this->assertFileExists(vfsStream::url('public/some.css'));
        $this->assertFileExists(vfsStream::url('public/another.css'));        
    }
}
