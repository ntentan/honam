<?php

namespace ntentan\honam\engines\php\helpers\form;

class Password extends Text
{
    public function render()
    {
        $this->setAttribute('type', 'password');
        return parent::render();
    }
}
