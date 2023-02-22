<?php

namespace ntentan\honam\engines\php\helpers\form;

use ntentan\honam\engines\php\Variable;

/**
 * The form field class. 
 * This class represents a form field element. Subclasses of this class are to be used to capture information from the 
 * user of the application.
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
    public final function __construct(string $label = "", string $name = "", string $value = "")
    {
        $this->name = $name === "" ? $label : $name; // Repeat the label as name if name is empty
        $this->value = $value;
        $this->label = $label;
        $this->setAttribute("id", "field-{$this->name}");
    }

    /**
     * Sets the value of the field.
     *
     * @param string $value The value of the field.
     * @return Field
     */
    public function setValue(string|null|Variable $value): Field
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get the value of the field.
     *
     * @return mixed
     */
    public function getValue(): ?string
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
    public function setData(array|Variable $data): Field
    {
        $fieldNames = array_keys(is_a($data, Variable::class) ? $data->unescape() : $data);
        if (array_search($this->getName(), $fieldNames) !== false) {
            $this->setValue($data[$this->getName()]);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->setAttribute("name", $this->getName());
        return $this->templateRenderer->render("input_element.tpl.php", array('element' => $this));
    }

    public function isContainer()
    {
        return false;
    }
}
