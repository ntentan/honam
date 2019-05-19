<?php

/*
 * Forms helper
 * 
 * Ntentan Framework
 * Copyright (c) 2008-2012 James Ekow Abaka Ainooson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 * 
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright Copyright 2010 James Ekow Abaka Ainooson
 * @license MIT
 */

namespace ntentan\honam\helpers;

use ntentan\honam\Helper;

use ntentan\honam\helpers\form\Container;
use ntentan\honam\exceptions\HelperException;
use ntentan\utils\Text;
use \ReflectionMethod;
use \ReflectionClass;

/**
 * Forms helper for rendering forms.
 */
class FormHelper extends Helper
{

    private $container;
    private $data = array();
    private $errors = array();


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

    public function create()
    {
        $args = func_get_args();
        $element = array_shift($args);
        return $this->createElement($element, $args);
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

    public function open($formId = '')
    {
        $this->container = $this->create('Form');
        if ($formId != '') {
            $this->container->setId($formId);
        }
        $this->container->setRenderMode(form\Container::RENDER_MODE_HEAD);
        return $this->container;
    }

    public function close($submit = 'Submit')
    {
        $arguments = func_get_args();
        if ($submit === false) {
            $this->container->setShowSubmit(false);
        } else if (count($arguments) > 0) {
            $this->container->setSubmitValues($arguments);
        }
        $this->container->setRenderMode(form\Container::RENDER_MODE_FOOT);
        return $this->container;
    }

    public function __call($function, $arguments)
    {
        if (substr($function, 0, 5) == "open_") {
            $container = $this->createElement(Text::ucamelize(substr($function, 5, strlen($function))), $arguments);
            $container->setRenderMode(Container::RENDER_MODE_HEAD);
            return $container;
        }

        elseif (substr($function, 0, 6) == "close_") {
            $container = $this->createElement(Text::ucamelize(substr($function, 5, strlen($function))), $arguments);
            $container->setRenderMode(Container::RENDER_MODE_FOOT);
            return $container;
        }

        elseif (substr($function, 0, 4) == "get_") {
            $element = $this->createElement(Text::ucamelize(substr($function, 4, strlen($function))), $arguments);
            $name = $element->getName();
            if (isset($this->data[$name])) {
                $element->setValue($this->data[$name]);
            }
            if (isset($this->errors[$name])) {
                $element->setErrors($this->errors[$name]);
            }
            return $element;
        }

        elseif (substr($function, 0, 4) == "add_") {
            $element = $this->createElement(Text::ucamelize(substr($function, 4, strlen($function))), $arguments);
            return $this->container->add($element);
        }

        else {
            throw new HelperException("Function *$function* not found in form helper.");
        }
    }

    private function getContainer()
    {
        if ($this->container === null) {
            $this->container = $this->createElement("Form", []);
        }
        return $this->container;
    }

}
