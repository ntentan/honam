<?php
/**
 * Checkboxes for forms
 * 
 * Ntentan Framework
 * Copyright (c) 2008-2012 James Ekow Abaka Ainooson
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
 * A regular checkbox with a label.
 */
class CheckableField extends Field
{
    /**
     * The value that this field should contain if this checkbox is checked.
     */
    protected $checkedValue;

    /**
     * Constructor for the checkbox.
     *
     * @param string $label The label of the checkbox.
     * @param string $name The name of the checkbox used for the name='' attribute of the HTML output
     * @param string $value A value to assign to this checkbox.
     * @param string $description A description of the field.
     */
    public function __construct($label="", $name="", $value="", $description="")
    {
        Element::__construct($label, $description);
        parent::__construct($name);
        $this->setCheckedValue($value);
        $this->setRenderLabel(false);
    }

    /**
     * Sets the value that should be assigned as the checked value for
     * this check box.
     * @param string $checkedValue
     * @return CheckableField
     */
    public function setCheckedValue($checkedValue)
    {
        $this->checkedValue = $checkedValue;
        return $this;
    }

    /**
     * Gets and returns the checkedValue for the check box.
     * @return string
     */
    public function getCheckedValue()
    {
        return $this->checkedValue;
    }

    public function render()
    {
        if($this->getCheckedValue() == (string)$this->getValue())
        {
            $this->setAttribute('checked', 'checked');
        }
        
        $this->setAttribute("name", $this->getName());
        $this->setAttribute("class", "{$this->getAttribute('type')} {$this->getCSSClasses()}");        
        $this->setValue($this->getCheckedValue());
        return $this->templateRenderer->render('input_checkable_element.tpl.php', array('element' => $this));
    }
}

