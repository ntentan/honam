<?php
namespace ntentan\honam\tests\cases;

class FormsHelperTest extends \ntentan\honam\tests\lib\HelperBaseTest
{
    public function testBasicForm()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_test.html'),   
            (string)$this->helpers->form->open(). (string)$this->helpers->form->close()
        );
    }
}