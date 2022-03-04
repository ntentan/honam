<?php
namespace ntentan\honam\engines\php\helpers\form;

class Text extends Field
{
    public function render()
    {
        $this->setAttribute('type', 'text');
        return parent::render();
    }
}
