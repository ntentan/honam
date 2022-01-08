<?php
namespace ntentan\honam\engines\php\helpers\form;

class DateField extends Text
{
    public function __construct($label="",$name="",$description="")
    {
        parent::__construct($label,$name,$description);
    	$this->setAttribute('type', 'date');
    }
}

