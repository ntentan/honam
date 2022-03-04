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
    protected $checkedValue = 1;

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
        if ($this->getCheckedValue() == (string)$this->getValue()) {
            $this->setAttribute('checked', 'checked');
        }

        return parent::render();
    }
}
