<?php
namespace ntentan\honam\engines\php\helpers\form;

use Error;
use ntentan\honam\engines\php\Variable;

/**
 * The container class. This abstract class provides the necessary basis for implementing form element containers. The 
 * container is a special element which contains other form elements.
 */
abstract class Container extends Element
{
    protected $elements = array();

    /**
     * @return string
     */
    abstract protected function renderHead();

    /**
     * @return string
     */
    abstract protected function renderFoot();

    /**
     * Method for adding an element to the form container.
     * @return Container
     */
    public function add(Element|array $element)
    {
        if (is_array($element)) {
            $this->elements = array_merge($this->elements, $element);
        } else {
            $this->elements[] = $element;
        }
        return $this;
    }

    /**
     * This method sets the data for the fields in this container. The parameter passed to this method is a structured 
     * array which has field names as keys and the values as value.
     */
    public function setData(array|Variable $data)
    {
        foreach ($this->elements as $element) {
            $element->setData($data);
        }
        return $this;
    }

    public function setErrors(array|Variable $errors): Element
    {
        foreach($this->elements as $element) {
            if ($element instanceof Container) {
                $element->setErrors($errors);
            } else {
                $fieldNames = array_keys(is_a($errors, Variable::class) ? $errors->unescape() : $errors);
                $fieldName = $element->getName();
                if (in_array($fieldName, $fieldNames)) {
                    $element->setErrors($errors[$fieldName]);
                }
            }
        }
        return $this;
    }

    public function render(): string
    {
        return $this->renderHead() 
            . $this->templateRenderer->render('elements.tpl.php', array('elements' => $this->getElements()))
            . $this->renderFoot();
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function isContainer()
    {
        return true;
    }
}
