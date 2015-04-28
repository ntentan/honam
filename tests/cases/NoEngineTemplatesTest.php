<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\TemplateEngine;

class NoEngineTemplatesTest extends \ntentan\honam\tests\lib\ViewBaseTest
{
    public function testLoading()
    {
        TemplateEngine::appendPath("tests/files/views/no_engine");
        TemplateEngine::render("no_engine", array());
    }
}
