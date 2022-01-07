<?php

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
    public function __construct(string $name = "", string $value = "")
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
    public function setValue(string $value): Field
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get the value of the field.
     *
     * @return mixed
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Sets the required status of the field.
     *
     * @param boolean $required
     * @return Field
     */
    public function setRequired(bool $required): Field
    {
        $this->required = $required;
        return $this;
    }

    /**
     * Returns the required status of the field.
     *
     * @return bool
     */
    public function getRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param $data
     */
    public function setData(array $data): Field
    {
        if (array_search($this->getName(), array_keys($data)) !== false) {
            $this->setValue($data[$this->getName()]);
        }
        return $this;
    }

    // public function getCSSClasses()
    // {
    //     $classes = parent::getCSSClasses();
    //     if ($this->error) $classes .= "error ";
    //     if ($this->getRequired()) $classes .= "required ";
    //     return trim($classes);
    // }

    /**
     * @return string
     */
    public function render()
    {
        //$this->setAttribute("class", "{$this->getAttribute('type')} {$this->getCSSClasses()}");
        $this->setAttribute("name", $this->getName());
        return $this->templateRenderer->render("input_element.tpl.php", array('element' => $this));
    }
}
