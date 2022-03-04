<?php

namespace ntentan\honam\engines\php\helpers\form;

class File extends Field
{
    public function render()
    {
        $this->setAttribute('type', 'file');
        return parent::render();
    }
}
