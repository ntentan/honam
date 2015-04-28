<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\TemplateEngine;
use ntentan\honam\AssetsLoader;

use org\bovigo\vfs\vfsStream;

class TemplatesTest extends \ntentan\honam\tests\lib\ViewBaseTest
{
    public function testTemplateLoading()
    {
        $output = TemplateEngine::render(
            'hello.tpl.php',
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Hello World! I am James Ainooson.", $output);
        
        TemplateEngine::prependPath("tests/files/views/secondary");
        $output = TemplateEngine::render(
            'hello.tpl.php',
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Hello World Again! I am James Ainooson.", $output);
        TemplateEngine::reset();
        TemplateEngine::appendPath('tests/files/views');
    }
    
    public function testSubPathTemplateLoading()
    {
        $output = TemplateEngine::render('some_login.tpl.php', array());
        $this->assertEquals("This is a Login Page?", $output);
        
        TemplateEngine::prependPath("tests/files/views/secondary");
        $output = TemplateEngine::render('some_login.tpl.php', array());
        $this->assertEquals("Is this another Login Page?", $output);
        TemplateEngine::reset();
        TemplateEngine::appendPath('tests/files/views');
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\TemplateResolutionException
     */
    public function testLayoutLoadFailure()
    {
        TemplateEngine::render('arbitrary.tpl.php', array());
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\TemplateEngineNotFoundException
     */    
    public function testEngineLoadFailure()
    {
        TemplateEngine::render('arbitrary.tpl.noengine', array());
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\FileNotFoundException
     */
    public function testAssetFileException()
    {
        vfsStream::setup('public');
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));   
        TemplateEngine::render('missing_asset.tpl.php', array());
    }    

    /**
     * @expectedException \ntentan\honam\exceptions\FilePermissionException
     */
    public function testPublicDirectoryException()
    {
        vfsStream::setup('public', 0444);
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));   
        TemplateEngine::render('assets.tpl.php', array());
    }        
    
    public function testAssetLoading()
    {
        vfsStream::setup('public');
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));
        touch(vfsStream::url('public/existing.css'));
        
        $output = TemplateEngine::render('assets.tpl.php', array());
        $this->assertEquals("vfs://public/some.css\nvfs://public/another.css\nvfs://public/existing.css", $output);
        $this->assertFileExists(vfsStream::url('public/some.css'));
        $this->assertFileExists(vfsStream::url('public/another.css'));        
    }
}
