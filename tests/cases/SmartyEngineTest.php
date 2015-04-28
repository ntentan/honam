<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\TemplateEngine;

class SmartyEngineTest extends \ntentan\honam\tests\lib\ViewBaseTest
{
    public function testInvocation()
    {
        $this->assertEquals(
            'Hello James Ainooson<form method="POST" class="fapi-form"><div class="form-submit-area"><input class="form-submit" type="submit" value="Submit" /></div></form>',
            TemplateEngine::render(
                "test.smarty", 
                array('firstname' => 'James', 'lastname' => 'Ainooson')
            )
        );
    }
}
