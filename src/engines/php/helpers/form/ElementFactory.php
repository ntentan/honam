<?php

namespace ntentan\honam\engines\php\helpers\form;

use ntentan\honam\exceptions\HonamException;
use ntentan\utils\Text;

/**
 * A trait that allows for chaining the methods in form elements.
 */
trait ElementFactory
{

    private $caller;

    /**
     * Recursively go through the chain of classes in the form to find one that supplies the required method.
     */
    public function findMethodClass($name)
    {
        if ($this->caller === null) {
            return null;
        } else if (method_exists($this->caller, $name)) {
            return $this->caller;
        } else {
            return $this->caller->findMethodClass($name);
        }
    }

    public function __call($name, $arguments)
    {
        // Check if the method exists in the object under which the element was created.
        $methodClass = $this->findMethodClass($name);
        if ($methodClass !== null) {
            return call_user_func_array([$methodClass, $name], $arguments);
        }

        if (str_starts_with($name, "open_")) {
            // Allow for magic methods that open containers.
            $containerCheck = true;
            $name = substr($name, 5);
        } else if (str_starts_with($name, "close_")) {
            // Allow for magic methods that close containers.
            return $this->popContainer(substr($name, 6));
        } else {
            $containerCheck = false;
        }

        // Create an instance of the element we need
        $elementClass = new \ReflectionClass(__NAMESPACE__ . "\\" . Text::ucamelize($name));
        /** @var Element|Container $element */
        $element = $elementClass->newInstanceArgs($arguments == null ? array() : $arguments);
        $element->setTemplateRenderer($this->templateRenderer);
        $element->setCaller($this);

        if ($containerCheck && is_a($element, __NAMESPACE__ . "\\Container")) {
            $this->pushContainer($name, $element);
        } else if ($containerCheck) {
            throw new HonamException("Element $name is not a container. Use the open_ prefix only when creating a container.");
        } else if ($this->hasActiveContainer()) {
            $this->getActiveContainer()->add($element);
        }

        return $element;
    }

    public function setCaller($caller)
    {
        $this->caller = $caller;
    }
}
