<?php
namespace ntentan\honam\engines\php\helpers\form;

class Text extends Field
{

    public function __construct($label="",$name="",$description="",$value="")
    {
        Field::__construct($name,$value);
        Element::__construct($label, $description);
        $this->setAttribute("type","text");
    }
}
