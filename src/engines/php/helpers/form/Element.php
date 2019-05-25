<?php
/**
 * Abstract form elements
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
 * The form element class. An element can be anything from the form
 * itself to the objects that are put in the form. Provides an
 * abstract render class that is used to output the HTML associated
 * with this form element. All visible elements of the form must be
 * subclasses of the element class.
 */
abstract class Element
{
    const SCOPE_ELEMENT = "";
    const SCOPE_WRAPPER = "_wrapper";

    /**
     * The id of the form useful for CSS styling and DOM access.
     * 
     * @var string
     */
    protected $id;

    /**
     * The label of the form element.
     * 
     * @var string
     */
    protected $label;

    /**
     * The description of the form element.
     * 
     * @var string
     */
    protected $description;

    /**
     * An array of all the CSS classes associated with this element.
     *
     * @var array 
     */
    protected $classes = array();
    
    /**
     * An array of all HTML attributes. These attributes are stored as
     * objects of the Attribute class. Attributes in this array are applied
     * directly to the form element.
     *
     * @var array 
     */    
    protected $attributes = array();
    
    /**
     * An array of all HTML attributes. These attributes are stored as
     * objects of the Attribute class. Attributes in this array are applied
     * directly to the wrapper which wraps the form element.
     *
     * @var array 
     */    
    protected $wrapperAttributes = array();
    
    /**
     * An array of all error messages associated with this element.
     * Error messages are setup during validation, when any element
     * fails its validation test.
     *
     * @var array
     */
    protected $errors = array();

    /**
     * A boolean value which is set to true whenever there is an error 
     * assiciated with the field element in one way or the other.
     */
    protected $error;

    /**
     * The parent element which contains this element.
     * @var Element
     */
    protected $parent = null;

    protected $name;

    protected $renderLabel = true;

    protected $templateRenderer;

    public function __construct($label="", $description="", $id="")
    {
        $this->setLabel($label);
        $this->setDescription($description);
        $this->setId($id);
    }
    
    public function setId($id)
    {
        $this->id = str_replace(".","_",$id);
        $this->setAttribute('id', $this->id);
        return $this;        
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Public accessor for setting the name property of the field.
     *
     * @param  string $name
     * @return Element
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Public accessor for getting the name property of the field.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    //! Sets the label which is attached to this element.
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    //! Gets the label which is attached to this element.
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Gets the description which is attached to this element. The description
     * is normally displayed under the element when rendering HTML.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description which is attached to this element. The description
     * is normally displayed under the element when rendering HTML.
     *
     * @return Element
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Returns all the arrays associated with this document.
     *
     * @return array 
     */
    public function getErrors()
    {
        return $this->errors;
    }

    // Returns the error flag for this element.
    public function hasError()
    {
        return $this->error;
    }

    public function getType()
    {
        return __CLASS__;
    }

    /**
     * Renders the form element by outputing the HTML associated with
     * the element. This method is abstract and it is implemented by
     * all the other classes which inherit the Element class.
     *
     * @return string
     */
    abstract public function render();

    public function __toString()
    {
        return $this->templateRenderer->render("inline_layout_element.tpl.php", array('element' => $this));
    }

    //! Returns an array of all the CSS classes associated with this
    //! element.
    public function getCSSClasses()
    {
        return implode(" ", $this->classes);
    }

    //! Adds a css class to this element.
    public function addCSSClass($class)
    {
        $this->classes[] = $class;
        return $this;
    }

    //! Adds an attribute to the list of attributes of this element.
    //! This method internally creates a new Attribute object and appends
    //! it to the list of attributes.
    //! \see Attribute
    public function setAttribute($attribute,$value,$scope = Element::SCOPE_ELEMENT)
    {
        // Force the setting of the attribute.
        if($scope == Element::SCOPE_ELEMENT)
        {
            $this->attributes[$attribute] = $value;
        }
        else if($scope == Element::SCOPE_WRAPPER)
        {
            $this->wrapperAttributes[$attribute] = $value;
        }
        return $this;
    }

    /**
     * Returns an HTML representation of all the attributes. This method is 
     * normally called when rendering the HTML for the element.
     */
    public function getAttributes($scope=Element::SCOPE_ELEMENT)
    {
        $attributes = array();
        switch($scope)
        {
            case Element::SCOPE_ELEMENT: $attributes = $this->attributes; break;
            case Element::SCOPE_WRAPPER: $attributes = $this->wrapperAttributes; break;
        }
        return $attributes;
    }
    
    public function getAttribute($attribute, $scope = Element::SCOPE_ELEMENT)
    {
        $attributes = $this->getAttributes($scope);
        return @$attributes[$attribute];
    }
    
    public function setErrors($errors)
    {
        $this->errors = $errors;
        $this->error = true;
    }
    
    public function getRenderLabel()
    {
        return $this->renderLabel;
    }
    
    public function setRenderLabel($renderLabel)
    {
        $this->renderLabel = $renderLabel;
    }

    public function setTemplateRenderer($templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }
}

