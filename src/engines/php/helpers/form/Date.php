<?php
namespace ntentan\honam\engines\php\helpers\form;

class Date extends Text
{
    public function __construct($label="",$name="",$description="")
    {
        parent::__construct($label,$name,$description);
    	$this->setAttribute('type', 'date');
    }
}

