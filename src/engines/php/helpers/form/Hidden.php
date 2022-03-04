<?php

namespace ntentan\honam\engines\php\helpers\form;


class Hidden extends Field
{
    public function render()
    {
        $this->setAttribute('type', 'hidden');
        return parent::render();
    }
}
