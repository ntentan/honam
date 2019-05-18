<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\engines\php\helpers\form\Fieldset;
use ntentan\honam\tests\lib\HelperTestCase;

class FormsHelperTest extends HelperTestCase
{
    public function testBasicForm()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_test.html'),   
            $this->helpers->form->open()->__toString() . $this->helpers->form->close()->__toString()
        );
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_id_test.html'),   
            $this->helpers->form->open('form-with-id')->__toString() . $this->helpers->form->close()->__toString()
        );        
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_no_submit_test.html'),   
            $this->helpers->form->open('form-with-id')->__toString() . $this->helpers->form->close(false)->__toString()
        ); 
        
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/basic_form_multi_submit_test.html'),   
            $this->helpers->form->open('form-with-id')->__toString() .
            $this->helpers->form->close('Close', 'Resolve', 'Comment')->__toString()
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
            $this->helpers->form->open()->__toString() .
            $this->helpers->form->get_text_field('Username', 'username')->__toString() .
            $this->helpers->form->get_password_field('Password', 'password')->__toString().
            $this->helpers->form->close('Login')->__toString()
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
            (string)$this->helpers->form->open()->__toString().
            (string)$this->helpers->form->get_text_field('TextField', 'textfield')->setDescription('A sample text field')->__toString().
            (string)$this->helpers->form->get_date_field('DateField', 'datefield')->setDescription('A sample date field')->setRequired(true)->__toString().
            (string)$this->helpers->form->get_hidden_field('HiddenField', 'hiddenfield')->setDescription('A sample hidden field')->__toString().
            (string)$this->helpers->form->get_checkbox('Something worth checking', 'checkbox')->setDescription('A sample checkbox')->__toString().
            (string)$this->helpers->form->get_password_field('Password', 'password')->setDescription('A sample password field')->__toString().
            (string)$this->helpers->form->get_radio_button('Option 1', 'radio_button', 'selected')->setDescription('A sample radio button')->__toString().
            (string)$this->helpers->form->get_radio_button('Option 2', 'radio_button', 'not_selected')->setDescription('Another sample radio button')->__toString().
            (string)$this->helpers->form->get_selection_list('Select', 'select')
                ->option('Selected', 'selected')
                ->option('Not Selected', 'not_selected')
                ->setOptions(
                    array(
                        'one' => 'One',
                        'two' => 'Two',
                    ),
                    true
                )->setMultiple(true)->initial('one')->__toString().
            (string)$this->helpers->form->get_text_area('Text', 'textarea')->__toString().
            (string)$this->helpers->form->get_upload_field('File', 'upload')->__toString().
            (string)$this->helpers->form->close()->__toString()
        );
    }
    
    public function testFormCreate()
    {
        $element = $this->helpers->form->create('TextField', 'Test', 'test')->setDescription('A test form');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/text_field.html'),   
            (string)$element->__toString()
        ); 
    }
    
    public function testFormAdd()
    {
        $this->helpers->form->setId('login-form');
        $this->helpers->form->add('TextField', 'Username', 'username');
        $this->helpers->form->add('PasswordField', 'Password', 'password');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_form.html'),
            (string)$this->helpers->form->__toString()
        );
    }
    
    public function testFormAddSetData()
    {
        $this->helpers->form->setId('login-form');
        $this->helpers->form->setData(array(
            'username' => 'james',
            'password' => 'janice'
            )
        );
        $this->helpers->form->add('TextField', 'Username', 'username');
        $this->helpers->form->add('PasswordField', 'Password', 'password');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_form_values.html'),
            (string)$this->helpers->form->__toString()
        );
    }    
    
    public function testFormAdd2()
    {
        $this->helpers->form->setId('login-form');
        $this->helpers->form->add_text_field('Username', 'username');
        $this->helpers->form->add_password_field('Password', 'password');
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_form.html'),
            (string)$this->helpers->form->__toString()
        );
    }    
    
    public function testFieldSet()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/login_fieldset.html'),        
            (string)$this->helpers->form->open()->__toString() .
            (string)$this->helpers->form->open_fieldset("Login")->__toString().
            (string)$this->helpers->form->get_text_field('Username', 'username')->__toString() .
            (string)$this->helpers->form->get_password_field('Password', 'password')->__toString().
            (string)$this->helpers->form->close_field_set()->__toString().
            (string)$this->helpers->form->close('Login')->__toString()
        );
    }   
    
    public function testFormAttributes()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/form_attributes.html'),    
            (string)$this->helpers->form->open()->setAttribute('target', '_blank')->__toString() . (string)$this->helpers->form->close()->__toString()
        );
    }
    
    /**
     * @expectedException \ntentan\honam\exceptions\HelperException
     */
    public function testWrongMethod()
    {
        $this->helpers->form->fail();
    }
    
    public function testStyling()
    {
        $form = $this->helpers->form->open() .
            $this->helpers->form->get_text_field('Some Text', 'some_text')
                ->setAttribute('style', 'border:1px solid green')
                ->addCSSClass('someclass').
            $this->helpers->form->close();
        $this->assertXmlStringEqualsXmlString(file_get_contents('tests/files/markup/form_styling.html'), $form);
    }
    
    public function testActionAttribute()
    {
        $form = $this->helpers->form->open()->setAction("/some/form/processor") .
            $this->helpers->form->get_text_field('Some Text', 'some_text').
            $this->helpers->form->close();
        $this->assertXmlStringEqualsXmlString(file_get_contents('tests/files/markup/form_action.html'), $form);
    }    
}
