<?php
include_once "Field.php";

//! A Field for containing radio buttons.
//! \ingroup Form_API
class RadioGroup extends Field
{
	//! The buttons found in the radio group.
	protected $buttons = array();

	//! The constructor for the radio group.
	public function __construct($label="",$name="",$description="")
	{
		$this->setLabel($label);
		$this->setName($name);
		$this->setDescription($description);
	}

	//! Adds a radio button to the radio group.
	public function add($button)
	{
		if($button->getType()=="RadioButton")
		{
			$button->setName($this->getName(false));
			$button->setNameEncryption($this->getNameEncryption());
			$button->setNameEncryptionKey($this->getNameEncryptionKey());
			$button->setId($this->getId());
			array_push($this->buttons, $button);
		}
		else
		{
			throw new Exception("Object added to radio group is not of type RadioButton");
		}
	}

	public function removeRadioButton($index)
	{

	}

	//! Render the form.
	public function render()
	{
		$ret = "";
		foreach($this->buttons as $button)
		{
			$ret .= "<div class='fapi-radio-button'>";
			$ret .= $button->render();
			$ret .= "</div>";
		}
		return $ret;
	}

	public function hasOptions()
	{
		return true;
	}

	//! Return the data that is stored in this radio group.
	public function getData($storable=false)
	{
		if($this->getMethod()=="POST")
		{
			$this->setValue($_POST[$this->getName()]);
		}
		else if($this->getMethod()=="GET")
		{
			$this->setValue($_GET[$this->getName()]);
		}
		return array($this->getName(false) => $this->getValue());
	}

	public function setNameEncryption($nameEncryption)
	{
		Element::setNameEncryption($nameEncryption);
		foreach($this->buttons as $element)
		{
			$element->setNameEncryption($nameEncryption);
		}
	}

	public function setNameEncryptionKey($nameEncryptionKey)
	{
		Element::setNameEncryptionKey($nameEncryptionKey);
		foreach($this->buttons as $element)
		{
			$element->setNameEncryptionKey($nameEncryptionKey);
		}
	}

	public function setValue($value)
	{
		//Field::setValue($value);
		$error = $this->resolve($value);
		if($error=="")
		{
			foreach($this->buttons as $elements)
			{
				$elements->setValue($value);
			}
		}
		return $error;
	}

	public function getDisplayValue()
	{
		foreach($this->buttons as $element)
		{
			if($this->getValue()==$element->getCheckedValue())
			{
				return $element->getLabel();
            }
        }
    }

    public function getOptions()
    {
    	$options = array();
    	foreach($this->buttons as $button)
    	{
    		$options += array($button->getCheckedValue()=>$button->getLabel());
    	}
    	return $options;
    }
}
?>
