<?php
namespace ntentan\views\tests\cases;

use ntentan\views\template_engines\AssetsLoader;
use org\bovigo\vfs\vfsStream;

class CssMinifierTest extends \ntentan\views\tests\lib\HelperBaseTest
{
    public function setUp() 
    {
        vfsStream::setup('public');
        mkdir(vfsStream::url('public/css'));
        parent::setUp();
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));
    }
    
    /**
     * @expectedException ntentan\views\exceptions\FileNotFoundException
     */
    public function testException()
    {
        $this->helpers->stylesheets->add('js/fapi.css')->__toString();
    }
    
    public function testOpen()
    {
        $this->assertEquals(file_get_contents('tests/files/markup/css_non_minified.html'), 
            (string)$this->helpers->stylesheets
                ->add('tests/files/assets/css/fapi.css')
                ->add('tests/files/assets/css/tapi.css')
        );
        $this->assertFileExists(vfsStream::url('public/css/fapi.css'));
        $this->assertFileExists(vfsStream::url('public/css/tapi.css'));
    }

    public function testMinifies()
    {
        $this->assertEquals(
            "<link type='text/css' rel='stylesheet' href='vfs://public/css/combined_default.css' />",
            (string)$this->helpers->stylesheets
                ->add('tests/files/assets/css/fapi.css')
                ->add('tests/files/assets/css/tapi.css')
                ->combine(true)
        );
        $this->assertFileExists(vfsStream::url('public/css/combined_default.css'));
    }    
}