<?php
namespace ntentan\honam\engines\php\helpers\form;

class Date extends Text
{
    public function render()
    {
        $this->setAttribute('type', 'date');
        return parent::render();
    }
}

