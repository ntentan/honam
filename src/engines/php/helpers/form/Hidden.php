<?php

namespace ntentan\honam\engines\php\helpers\form;


class Hidden extends Field
{
    public function __construct($name="", $value="")
    {
        parent::__construct($name, $value);
        $this->setAttribute('type', 'hidden');
    }
}
