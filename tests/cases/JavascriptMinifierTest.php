<?php
namespace ntentan\views\tests\cases;

use ntentan\views\template_engines\AssetsLoader;
use org\bovigo\vfs\vfsStream;

class JavascriptMinifierTest extends \ntentan\views\tests\lib\HelperBaseTest
{
    public function setUp() 
    {
        vfsStream::setup('public');
        mkdir(vfsStream::url('public/js'));
        parent::setUp();
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));
    }
    
    /**
     * @expectedException ntentan\views\exceptions\FileNotFoundException
     */
    public function testException()
    {
        $this->helpers->javascripts->add('js/fap.js')->__toString();
    }
    
    public function testOpen()
    {
        $this->assertEquals(file_get_contents('tests/files/markup/javascript_non_minified.html'), 
            (string)$this->helpers->javascripts
                ->add('tests/files/assets/js/fapi.js')
                ->add('tests/files/assets/js/wyf.js')
        );
        $this->assertFileExists(vfsStream::url('public/js/fapi.js'));
        $this->assertFileExists(vfsStream::url('public/js/wyf.js'));
    }
    
    public function testOpenArray()
    {
        $this->assertEquals(file_get_contents('tests/files/markup/javascript_non_minified.html'), 
            (string)$this->helpers->javascripts
                ->add(
                    array(
                        'tests/files/assets/js/fapi.js',
                        'tests/files/assets/js/wyf.js'                        
                    )
                )        
        );
        $this->assertFileExists(vfsStream::url('public/js/fapi.js'));
        $this->assertFileExists(vfsStream::url('public/js/wyf.js'));
    }    
    
    public function testMinifies()
    {
        $this->assertEquals(
            "<script type='text/javascript' src='vfs://public/js/combined_default.js' charset='utf-8'></script>",
            (string)$this->helpers->javascripts
                ->add('tests/files/assets/js/fapi.js')
                ->add('tests/files/assets/js/wyf.js')
                ->combine(true)
        );
        $this->assertFileExists(vfsStream::url('public/js/combined_default.js'));
    }
    
    public function testMinifiesContext()
    {
        $this->assertEquals(
            "<script type='text/javascript' src='vfs://public/js/combined_admin.js' charset='utf-8'></script>",
            (string)$this->helpers->javascripts
                ->add('tests/files/assets/js/fapi.js')
                ->add('tests/files/assets/js/wyf.js')
                ->combine(true)
                ->context('admin')
        );
        $this->assertFileExists(vfsStream::url('public/js/combined_admin.js'));
    }    

    public function testMinifiesArray()
    {
        $this->assertEquals(
            "<script type='text/javascript' src='vfs://public/js/combined_default.js' charset='utf-8'></script>",
            (string)$this->helpers->javascripts
                ->add(
                    array(
                        'tests/files/assets/js/fapi.js',
                        'tests/files/assets/js/wyf.js'                        
                    )
                )->combine(true)
        );
        $this->assertFileExists(vfsStream::url('public/js/combined_default.js'));
    }
    
    public function testOtherScripts()
    {
        $this->assertEquals(file_get_contents('tests/files/markup/javascript_non_minified.html'), 
            (string)$this->helpers->javascripts(
                    array(
                        'tests/files/assets/js/fapi.js',
                        'tests/files/assets/js/wyf.js'                        
                    )
                )        
        );
        $this->assertFileExists(vfsStream::url('public/js/fapi.js'));
        $this->assertFileExists(vfsStream::url('public/js/wyf.js'));
    }        

    public function testMinifiesHelp()
    {
        $this->assertEquals(
            file_get_contents('tests/files/markup/javascript_non_minified.html'), 
            $this->helpers->javascripts('tests/files/assets/js/fapi.js')->__toString().
            $this->helpers->javascripts('tests/files/assets/js/wyf.js')->__toString()
        );
    }
}
