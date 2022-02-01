<?php
namespace ntentan\honam\engines\php\helpers\form;

/**
 * A regular checkbox with a label.
 */
class Checkable extends Field
{
    protected $hasLabel = false;

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
    public function __construct(string $label="", string $name="", string $value="")
    {
        Element::__construct($label);
        parent::__construct($name);
        $this->setCheckedValue($value);
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
        $this->setValue($this->getCheckedValue());
        return $this->templateRenderer->render('input_checkable_element.tpl.php', array('element' => $this));
    }
}
