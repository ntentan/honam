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
    
    public function testSetErrors()
    {
        $this->helpers->form->setErrors(
            array(
                'username' => array(
                    'Invalid username or password',
                    'Username must be unique'
                ),
                'password' => array(
                    'Password must contain six or more characters'
                )
            )
        );
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_errors.html'),
            (string)$this->helpers->form->open() . 
            (string)$this->helpers->form->get_text_field('Username', 'username') .
            (string)$this->helpers->form->get_password_field('Password', 'password').
            (string)$this->helpers->form->close('Login')
        );
    }
    
    public function testSetData()
    {
        $this->helpers->form->setData(
            array(
                'textfield' => 'Text Field',
                'datefield' => '2012-01-01',
                'hiddenfield' => 'Some Hidden Text',
                'checkbox' => '1',
                'password' => 'This should be hidden',
                'radio_button' => 'selected',
                'select' => 'selected',
                'textarea' => 'Blah blah blah'
            )
        );
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/big_form.html'), 
            (string)$this->helpers->form->open().
            (string)$this->helpers->form->get_text_field('TextField', 'textfield')->setDescription('A sample text field').
            (string)$this->helpers->form->get_date_field('DateField', 'datefield')->setDescription('A sample date field')->setRequired(true).
            (string)$this->helpers->form->get_hidden_field('HiddenField', 'hiddenfield')->setDescription('A sample hidden field').
            (string)$this->helpers->form->get_checkbox('Something worth checking', 'checkbox')->setDescription('A sample checkbox').
            (string)$this->helpers->form->get_password_field('Password', 'password')->setDescription('A sample password field').
            (string)$this->helpers->form->get_radio_button('Option 1', 'radio_button', 'selected')->setDescription('A sample radio button').
            (string)$this->helpers->form->get_radio_button('Option 2', 'radio_button', 'not_selected')->setDescription('Another sample radio button').
            (string)$this->helpers->form->get_selection_list('Select', 'select')
                ->option('Selected', 'selected')
                ->option('Not Selected', 'not_selected')
                ->options(
                    array(
                        'one' => 'One',
                        'two' => 'Two',
                    ),
                    true
                )->setMultiple(true)->initial('one').
            (string)$this->helpers->form->get_text_area('Text', 'textarea').
            (string)$this->helpers->form->get_upload_field('File', 'upload').
            (string)$this->helpers->form->close()
        );
    }
    
    public function testFormCSS()
    {
        $this->assertFileExists($this->helpers->form->stylesheet());
    }
    
    public function testFormCreate()
    {
        $element = $this->helpers->form->create('TextField', 'Test', 'test')->setDescription('A test form');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/text_field.html'),   
            $element
        ); 
    }
    
    public function testFormAdd()
    {
        $this->helpers->form->setId('login-form');
        $this->helpers->form->add('TextField', 'Username', 'username');
        $this->helpers->form->add('PasswordField', 'Password', 'password');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_form.html'),
            $this->helpers->form
        );
    }
    
    public function testFormAdd2()
    {
        $this->helpers->form->setId('login-form');
        $this->helpers->form->add_text_field('Username', 'username');
        $this->helpers->form->add_password_field('Password', 'password');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_form.html'),
            $this->helpers->form
        );
    }    
    
    public function testFieldSet()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_fieldset.html'),        
            (string)$this->helpers->form->open() . 
            (string)$this->helpers->form->open_field_set("Login").
            (string)$this->helpers->form->get_text_field('Username', 'username') .
            (string)$this->helpers->form->get_password_field('Password', 'password').
            (string)$this->helpers->form->close_field_set().
            (string)$this->helpers->form->close('Login')
        );
    }   
    
    public function testFormAttributes()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/form_attributes.html'),    
            (string)$this->helpers->form->open()->setAttribute('target', '_blank') . (string)$this->helpers->form->close()
        );
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\HelperException
     */
    public function testWrongMethod()
    {
        $this->helpers->form->fail();
    }
    
    public function testContainers()
    {
        $fieldset = new \ntentan\honam\helpers\form\api\Fieldset();
        $this->assertEquals(true, $fieldset->isContainer());
    }
}
