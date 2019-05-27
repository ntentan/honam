<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\ViewBaseTest;

class SmartyEngineTest extends ViewBaseTest
{
    public function testInvocation()
    {
        $this->assertEquals(
            'Hello James Ainooson',
            $this->templateRenderer->render("test.smarty", array('firstname' => 'James', 'lastname' => 'Ainooson'))
        );
    }
}
