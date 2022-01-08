<?php
namespace ntentan\honam\engines\php\helpers\form;

/**
 * The container class. This abstract class provides the necessary
 * basis for implementing form element containers. The container
 * is a special element which contains other form elements.
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
    public function add(Element $element)
    {
        $this->elements[] = $element;
    }

    /**
     * This method sets the data for the fields in this container. The parameter passed to this method is a structured 
     * array which has field names as keys and the values as value.
     */
    public function setData($data)
    {
        if (is_array($data)) {
            foreach ($this->elements as $element) {
                $element->setData($data);
            }
        }
    }

    public function render()
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
