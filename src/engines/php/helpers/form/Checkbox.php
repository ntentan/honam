<?php
namespace ntentan\honam\engines\php\helpers\form;


/**
 * A regular checkbox with a label.
 */
class Checkbox extends Checkable
{

    /**
     * Constructor for the checkbox.
     *
     * @param string $label The label of the checkbox.
     * @param string $name The name of the checkbox used for the name='' attribute of the HTML output
     * @param string $value A value to assign to this checkbox.
     * @param string $description A description of the field.
     */
    public function __construct($label="", $name="", $value="1")
    {
        parent::__construct($label, $name, $value);
        $this->setAttribute('type', 'checkbox');
    }
}

