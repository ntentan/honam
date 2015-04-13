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
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_id_test.html'),   
            (string)$this->helpers->form->open('form-with-id'). (string)$this->helpers->form->close()
        );        
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_no_submit_test.html'),   
            (string)$this->helpers->form->open('form-with-id'). (string)$this->helpers->form->close(false)
        ); 
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_multi_submit_test.html'),   
            (string)$this->helpers->form->open('form-with-id'). 
            (string)$this->helpers->form->close('Close', 'Resolve', 'Comment')
        ); 
    }
    
    public function testMultipleSubmit()
    {
        
    }
    
    public function testFormCSS()
    {
        $this->assertFileExists($this->helpers->form->stylesheet());
    }
    
    public function testFormCreate()
    {
        $element = $this->helpers->form->create('TextField', 'Test', 'test')->description('A test form');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/text_field.html'),   
            $element
        ); 
    }
    
    public function testFormAdd()
    {
        $this->helpers->form->add('TextField', 'Username', 'username');
        $this->helpers->form->add('PasswordField', 'Password', 'password');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_form.html'),
            $this->helpers->form
        );
    }
}
