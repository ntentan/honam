<?php
namespace ntentan\honam\engines\php\helpers\form;


/**
 * A regular checkbox with a label.
 */
class Checkbox extends Checkable
{
    public function render()
    {
        $this->setAttribute('type', 'checkbox');
        return parent::render();
    }
}

