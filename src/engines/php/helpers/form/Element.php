<?php

namespace ntentan\honam\engines\php\helpers\form;

use ntentan\honam\engines\php\Variable;
use ntentan\honam\TemplateRenderer;


/**
 * The form element class. 
 * An element can be anything from the form itself to the elements on the form. This class provides an abstract render 
 * method that elements use to output their HTML code. Any visible element of the form must have this class as a parent.
 */
abstract class Element
{
    use ElementFactory;

    /**
     * The id of the form useful for CSS styling and DOM access.
     * 
     * @var string
     */
    protected $id = "";

    /**
     * The label of the form element.
     * 
     * @var string
     */
    protected $label = "";

    /**
     * The description of the form element.
     * 
     * @var string
     */
    protected $description = "";

    /**
     * An array of all the CSS classes associated with this element.
     *
     * @var array 
     */
    protected $classes = [];

    /**
     * An array of all HTML attributes. These attributes are stored as
     * objects of the Attribute class. Attributes in this array are applied
     * directly to the form element.
     *
     * @var array 
     */
    protected $attributes = [];

    /**
     * An array of all HTML attributes. These attributes are stored as
     * objects of the Attribute class. Attributes in this array are applied
     * directly to the wrapper which wraps the form element.
     *
     * @var array 
     */
    //protected $wrapperAttributes = [];

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
     * @var boolean
     */
    protected $error = false;

    protected $name;

    protected $hasLabel = true;

    protected $templateRenderer;

    public function __construct(string $label = "")
    {
        $this->setLabel($label);
    }

    public function setId(string $id): Element
    {
        $this->id = $id;
        $this->setAttribute('id', $this->id);
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Public accessor for setting the name property of the field.
     *
     * @param  string $name
     * @return Element
     */
    public function setName($name): Element
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Public accessor for getting the name property of the field.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set a label for the form element.
     */
    public function setLabel(string $label): Element
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the label for the form element.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Gets the description which is attached to this element. The description is normally displayed under the element 
     * when rendering HTML.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description which is attached to this element. The description is normally displayed under the element 
     * when rendering HTML.
     *
     * @return Element
     */
    public function setDescription($description): Element
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Returns all the arrays associated with this document.
     *
     * @return array 
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasError(): bool
    {
        return $this->error;
    }

    /**
     * Renders the form element by outputing the HTML associated with the element. This method is abstract and it is 
     * implemented by all the other classes which inherit the Element class.
     *
     * @return string
     */
    abstract public function render();

    public function __toString()
    {
        return $this->templateRenderer->render("forms_layout_element.tpl.php", array('element' => $this));
    }

    /**
     * Adds an attribute to the element or its surrounding scope.
     */
    public function setAttribute(string $attribute, string $value) : Element
    {
        $this->attributes[$attribute] = $value;
        return $this;
    }

    /**
     * Returns an HTML representation of all the attributes. This method is normally called when rendering the HTML for 
     * the element.
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    public function getAttribute(string $attribute) : ?string
    {
        return $this->attributes[$attribute] ?? null;
    }

    public function setErrors(array|Variable $errors) : Element
    {
        $this->errors = $errors;
        $this->error = true;
        return $this;
    }

    public function setTemplateRenderer(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function getHasLabel(): bool
    {
        return $this->hasLabel;
    }
}
