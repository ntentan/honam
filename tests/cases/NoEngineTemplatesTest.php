<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\ViewBaseTest;

class NoEngineTemplatesTest extends ViewBaseTest
{
    public function testLoading()
    {
        $this->templateFileResolver->appendToPathHierarchy("tests/files/views/no_engine");
        $this->templateRenderer->render("no_engine", []);
    }
}
