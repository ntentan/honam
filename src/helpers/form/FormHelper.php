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

namespace ntentan\honam\helpers\form;

use ntentan\honam\helpers\Helper;
use ntentan\utils\Text;
use \ReflectionMethod;
use \ReflectionClass;

/**
 * Forms helper for rendering forms.
 */
class FormHelper extends Helper
{
    private $container;
    private static $layout = "inline";
    private $data = array();
    private $errors = array();
    
    public function __construct()
    {
        \ntentan\honam\template_engines\TemplateEngine::appendPath(
            __DIR__ . "/../../../templates/forms"
        );
    }
    
    /**
     * Renders the form when the value is used as a string
     * @return string
     */
    public function __toString()
    {
        $this->container->setData($this->data);
        $this->container->setErrors($this->errors);
        $return = (string)$this->container;
        $this->container = null;
        return $return;
    }
    
    public function stylesheet()
    {
        return __DIR__ . '/../../../assets/css/forms/forms.css';
    }
    
    public static function create()
    {
        $args = func_get_args();
        $element = __NAMESPACE__ . "\\api\\" . array_shift($args);
        $element = new ReflectionClass($element);
        return $element->newInstanceArgs($args==null?array():$args);
    }
    
    public function setId($id)
    {
        $this->getCotainer()->setId($id);
    }
        
    public function add()
    {
        $args = func_get_args();
        if(is_string($args[0]))
        {
            $elementClass = new ReflectionMethod(__NAMESPACE__ . "\\FormHelper", 'create');
            $element = $elementClass->invokeArgs(null, $args);
            $this->getCotainer()->add($element);
        }
        return $this;
    }
    
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
    
    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function open($formId = '')
    {
        $this->container = new api\Form();
        if($formId != '')
        {
            $this->container->setId($formId);
        }
        $this->container->rendererMode = 'head';
        return $this->container;        
    }
    
    public function close($submit = 'Submit')
    {
        $arguments = func_get_args();
        if($submit === false)
        {
            $this->container->setShowSubmit(false);
        }
        else if(count($arguments) > 0)
        {
            $this->container->setSubmitValues($arguments);
        }
        $this->container->rendererMode = 'foot';
        return $this->container;        
    }

    public function __call($function, $arguments)
    {
        if(substr($function, 0, 5) == "open_")
        {
            $container = __NAMESPACE__ . "\\api\\" . Text::ucamelize(substr($function, 5, strlen($function)));
            $containerClass = new ReflectionClass($container);
            $containerObject = $containerClass->newInstanceArgs($arguments);
            $return = $containerObject->renderHead();
        }
        elseif(substr($function, 0, 6) == "close_")
        {
            $container = __NAMESPACE__ . "\\api\\" . Text::ucamelize(substr($function, 6, strlen($function)));
            $containerClass = new ReflectionClass($container);
            $containerObject = $containerClass->newInstanceArgs($arguments);
            $return = $containerObject->renderFoot();
        }
        elseif(substr($function, 0, 4) == "get_")
        {
            $element = __NAMESPACE__ . "\\api\\" . Text::ucamelize(substr($function, 4, strlen($function)));
            $elementClass = new ReflectionClass($element);
            $elementObject = $elementClass->newInstanceArgs($arguments);
            $name = $elementObject->getName();
            if(isset($this->data[$name])) 
            {
                $elementObject->setValue($this->data[$name]);
            }
            if(isset($this->errors[$name]))
            {
                $elementObject->setErrors($this->errors[$name]);
            }
            $return = $elementObject;
        }
        elseif(substr($function, 0, 4) == "add_")
        {
            $element = __NAMESPACE__ . "\\api\\" . Text::ucamelize(substr($function, 4, strlen($function)));
            $elementClass = new ReflectionClass($element);
            $elementObject = $elementClass->newInstanceArgs($arguments);
            $return = $this->container->add($elementObject);
        }
        else
        {
            throw new \ntentan\honam\exceptions\HelperException("Function *$function* not found in form helper.");
        }
        
        return $return;
    }
    
    public static function getLayout()
    {
        return self::$layout;
    }
    
    public function getCotainer()
    {
        if($this->container === null)
        {
            $this->container = new api\Form();
        }
        return $this->container;
    }
}
