<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\template_engines\AssetsLoader;
use org\bovigo\vfs\vfsStream;

class CssMinifierTest extends \ntentan\honam\tests\lib\HelperBaseTest
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
     * @expectedException ntentan\honam\exceptions\FileNotFoundException
     */
    public function testException()
    {
        $this->helpers->stylesheets->add('js/fapi.css')->__toString();
    }    
    
    /*public function testOpen()
    {
        $this->assertEquals(file_get_contents('tests/files/markup/stylesheet_non_minified.html'), 
            (string)$this->helpers->javascripts
                ->add('tests/files/assets/js/fapi.js')
                ->add('tests/files/assets/js/wyf.js')
        );
        $this->assertFileExists(vfsStream::url('public/js/fapi.js'));
        $this->assertFileExists(vfsStream::url('public/js/wyf.js'));
    }*/    
}