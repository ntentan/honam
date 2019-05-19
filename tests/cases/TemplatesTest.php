<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\exceptions\TemplateEngineNotFoundException;
use ntentan\honam\exceptions\TemplateResolutionException;
use ntentan\honam\tests\lib\ViewBaseTest;

class TemplatesTest extends ViewBaseTest
{
    public function testTemplateLoading()
    {
        $output = $this->templateRenderer->render(
            'hello.tpl.php',
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Hello World! I am James Ainooson.", $output);
        
        $this->templateFileResolver->prependToPathHierarchy("tests/files/views/secondary");
        $output = $this->templateRenderer->render(
            'hello.tpl.php',
            array('firstname'=>'James', 'lastname'=>'Ainooson')
        );
        $this->assertEquals("Hello World Again! I am James Ainooson.", $output);
    }
    
    public function testSubPathTemplateLoading()
    {
        $output = $this->templateRenderer->render('some_login.tpl.php', array());
        $this->assertEquals("This is a Login Page?", $output);
        
        $this->templateFileResolver->prependToPathHierarchy("tests/files/views/secondary");
        $output = $this->templateRenderer->render('some_login.tpl.php', array());
        $this->assertEquals("Is this another Login Page?", $output);
    }
    
    public function testLayoutLoadFailure()
    {
        $this->expectException(TemplateResolutionException::class);
        $this->templateRenderer->render('arbitrary.tpl.php', array());
    }
    
    public function testEngineLoadFailure()
    {
        $this->expectException(TemplateEngineNotFoundException::class);
        $this->templateRenderer->render('arbitrary.tpl.noengine', array());
    }
}
