<?php

namespace ntentan\honam\engines\php\helpers\form;

/**
 * A regular checkbox with a label.
 */
class Checkable extends Field
{
    /**
     * The value that this field should contain if this checkbox is checked.
     */
    protected $checkedValue;

    public function __construct($label, $name, $checkedValue = 1)
    {
        parent::__construct($label, $name);
        $this->checkedValue = $checkedValue;
    }

    /**
     * Sets the value that should be assigned as the checked value for
     * this check box.
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
        if ($this->getCheckedValue() == (string) $this->getValue()) {
            $this->setAttribute('checked', 'checked');
        }
        $this->setAttribute("name", $this->getName());
        $this->setAttribute("value", $this->getCheckedValue());
        return $this->templateRenderer->render("input_checkable_element.tpl.php", array('element' => $this));
    }

    public function getHasLabel(): bool
    {
        return false;
    }
}
