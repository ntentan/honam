<?php
namespace ntentan\honam\tests\cases;

class DatesHelperTest extends \ntentan\honam\tests\lib\HonamBaseTest
{    
    public function testDateHelpers()
    {
        \ntentan\honam\template_engines\TemplateEngine::appendPath('tests/files/views/helpers');
        $this->view->setTemplate('date.tpl.php');
        var_dump($this->view->out(array()));
    }
}
