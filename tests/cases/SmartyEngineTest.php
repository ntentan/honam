<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\ViewBaseTest;

class SmartyEngineTest extends ViewBaseTest
{
    public function testInvocation()
    {
        $this->assertEquals(
            'Hello James Ainooson<form method="POST"><div class="form-submit-area"><input class="form-submit" type="submit" value="Submit" /></div></form>',
            $this->templateRenderer->render("test.smarty", array('firstname' => 'James', 'lastname' => 'Ainooson'))
        );
    }
}
