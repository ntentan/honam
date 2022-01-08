<?php

namespace ntentan\honam\engines\php\helpers\form;

class Password extends Text
{
    public function __construct(string $label = "", string $name = "", string $description = "")
    {
        parent::__construct($label, $name, $description);
        $this->setAttribute("type", "password");
    }
}
