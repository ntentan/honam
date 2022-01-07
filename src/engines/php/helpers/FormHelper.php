<?php

namespace ntentan\honam\engines\php\helpers;

use ntentan\honam\engines\php\Helper;
use ntentan\honam\engines\php\helpers\form\Container;
use ntentan\honam\engines\php\helpers\form\Form;
use ntentan\honam\exceptions\HelperException;
use ntentan\utils\Text;
use \ReflectionClass;

/**
 * A helper for rendering forms.
 */
class FormHelper extends Helper
{
    /**
     * An instance of the container for the Form.
     * @var Container
     */
    private $container;

    /**
     * Data to be rendered into the form.
     * @var array
     */
    private $data = [];

    /**
     * Any errors that should be rendered with the form.
     */
    private $errors = [];

    /**
     * Renders the form when the value is used as a string
     * @return string
     */
    public function __toString()
    {
        $this->container->setData($this->data);
        $this->container->setErrors($this->errors);
        $return = (string) $this->container;
        $this->container = null;
        return $return;
    }

    private function createElement($element, $args)
    {
        $elementClass = new ReflectionClass(__NAMESPACE__ . "\\form\\" . $element);
        $element = $elementClass->newInstanceArgs($args == null ? array() : $args);
        $element->setTemplateRenderer($this->templateRenderer);
        return $element;
    }

    public function setId($id)
    {
        $this->getContainer()->setId($id);
    }

    public function add()
    {
        $args = func_get_args();
        $element = array_shift($args);
        $this->getContainer()->add($this->createElement($element, $args));
        return $this;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this->container;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this->container;
    }

    public function open(string $formId = '')
    {
        $this->container = new Form(); //$this->create('Form');
        if ($formId != '') {
            $this->container->setId($formId);
        }
        $this->container->setRenderMode(Container::RENDER_MODE_HEAD);
        return $this;
    }

    public function close($submit = 'Submit')
    {
        $arguments = func_get_args();
        if ($submit === false) {
            $this->container->setShowSubmit(false);
        } else if (count($arguments) > 0) {
            $this->container->setSubmitValues($arguments);
        }
        $this->container->setRenderMode(Container::RENDER_MODE_FOOT);
        return $this;
    }

    public function __call($name, $arguments)
    {
        return $this->createElement($name, $arguments);
    }

    // public function __call($function, $arguments)
    // {
        // if (substr($function, 0, 5) == "open_") {
        //     $container = $this->createElement(Text::ucamelize(substr($function, 5, strlen($function))), $arguments);
        //     $container->setRenderMode(Container::RENDER_MODE_HEAD);
        //     return $container;
        // }

        // elseif (substr($function, 0, 6) == "close_") {
        //     $container = $this->createElement(Text::ucamelize(substr($function, 5, strlen($function))), $arguments);
        //     $container->setRenderMode(Container::RENDER_MODE_FOOT);
        //     return $container;
        // }

        // elseif (substr($function, 0, 4) == "get_") {
        //     $element = $this->createElement(Text::ucamelize(substr($function, 4, strlen($function))), $arguments);
        //     $name = $element->getName();
        //     if (isset($this->data[$name])) {
        //         $element->setValue($this->data[$name]);
        //     }
        //     if (isset($this->errors[$name])) {
        //         $element->setErrors($this->errors[$name]);
        //     }
        //     return $element;
        // }

        // elseif (substr($function, 0, 4) == "add_") {
        //     $element = $this->createElement(Text::ucamelize(substr($function, 4, strlen($function))), $arguments);
        //     return $this->container->add($element);
        // }

        // else {
        //     throw new HelperException("Function *$function* not found in form helper.");
        // }
    // }

    // private function getContainer()
    // {
    //     if ($this->container === null) {
    //         $this->container = $this->createElement("Form", []);
    //     }
    //     return $this->container;
    // }

}
