<?php

namespace ntentan\honam\engines\php\helpers\form;

class File extends Field
{
    public function __construct(string $label = "", string $name = "", string $description = "")
    {
        Field::__construct($name);
        Element::__construct($label, $description);
        $this->setAttribute("type", "file");
    }
}
