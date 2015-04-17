<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\template_engines\AssetsLoader;
use org\bovigo\vfs\vfsStream;

class JavascriptMinifierTest extends \ntentan\honam\tests\lib\HelperBaseTest
{
    public function setUp() 
    {
        vfsStream::setup('public');
        parent::setUp();
        AssetsLoader::setSourceDir('tests/files/assets');
        AssetsLoader::setDestinationDir(vfsStream::url('public'));
    }
    
    /**
     * @expectedException ntentan\honam\exceptions\FilePermissionException
     */
    public function testException()
    {
        $this->helpers->javascript->add(load_asset('js/fapi.js'));
    }
    
    public function testOpen()
    {
        mkdir(vfsStream::url('public/js'));
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
        mkdir(vfsStream::url('public/js'));
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
        mkdir(vfsStream::url('public/js'));
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
        mkdir(vfsStream::url('public/js'));
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
        mkdir(vfsStream::url('public/js'));
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
        mkdir(vfsStream::url('public/js'));
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
        mkdir(vfsStream::url('public/js'));
        $this->assertEquals(
            file_get_contents('tests/files/markup/javascript_non_minified.html'), 
            $this->helpers->javascripts('tests/files/assets/js/fapi.js')->__toString().
            $this->helpers->javascripts('tests/files/assets/js/wyf.js')->__toString()
        );
    }
}
