<?php
/**
 * Abstract form fields
 * 
 * Ntentan Framework
 * Copyright (c) 2008-2013 James Ekow Abaka Ainooson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 * 
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright Copyright 2010 James Ekow Abaka Ainooson
 * @license MIT
 */

namespace ntentan\honam\engines\php\helpers\form;


/**
 * The form field class. This class represents a form field element.
 * Subclasses of this class are to be used to capture information from
 * the user of the application.
 * \ingroup Form_API
 */
class Field extends Element
{
    /**
     * A flag for setting the required state of the form. If this value
     * is set as true then the form would not be validated if there is
     * no value entered into this field.
     */
    public $required = false;

    /**
     * The value of the form field.
     */
    protected $value;

    /**
     * The constructor for the field element.
     */
    public function __construct($name="", $value="")
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Sets the value of the field.
     *
     * @param string $value The value of the field.
     * @return Field
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get the value of the field.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the required status of the field.
     *
     * @param boolean $required
     * @return Field
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Returns the required status of the field.
     *
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        if(array_search($this->getName(),array_keys($data))!==false)
        {
            $this->setValue($data[$this->getName()]);
        }
    }

    public function getCSSClasses()
    {
        $classes = parent::getCSSClasses();
        if($this->error) $classes.="error ";
        if($this->getRequired()) $classes .="required ";
        return trim($classes);
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->setAttribute("class", "{$this->getAttribute('type')} {$this->getCSSClasses()}");
        $this->setAttribute("name", $this->getName());
        return $this->templateRenderer->render("input_element.tpl.php", array('element' => $this));
    }
}
