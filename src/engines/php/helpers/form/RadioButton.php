<?php
namespace ntentan\honam\engines\php\helpers\form;

/**
 * A regular checkbox with a label.
 */
class RadioButton extends Checkable
{
    public function render()
    {
        $this->setAttribute('type', 'radio');
        return parent::render();
    }
}

