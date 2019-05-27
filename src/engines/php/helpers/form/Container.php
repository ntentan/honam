<?php

/**
 * Containers for containing form elements
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

namespace ntentan\honam\engines\php\helpers\form;


/**
 * The container class. This abstract class provides the necessary
 * basis for implementing form element containers. The container
 * is a special element which contains other form elements.
 */
abstract class Container extends Element
{

    const RENDER_MODE_ALL = 'all';
    const RENDER_MODE_HEAD = 'head';
    const RENDER_MODE_FOOT = 'foot';

    protected $renderMode = self::RENDER_MODE_ALL;
    protected $elements = array();

    /**
     * @return string
     */
    abstract protected function renderHead();

    /**
     * @return string
     */
    abstract protected function renderFoot();
    
    public function setRenderMode($renderMode)
    {
        $this->renderMode = $renderMode;
    }

    private function addElement($element)
    {
        $this->elements[] = $element;
        $element->parent = $this;
    }

    /**
     * Method for adding an element to the form container.
     * @return Container
     */
    public function add()
    {
        $arguments = func_get_args();
        foreach ($arguments as $element) {
            $this->addElement($element);
        }
        return $this;
    }

    /**
     * This method sets the data for the fields in this container. The parameter
     * passed to this method is a structured array which has field names as keys
     * and the values as value.
     */
    public function setData($data)
    {
        if (is_array($data)) {
            foreach ($this->elements as $element) {
                $element->setData($data);
            }
        }
        return $this;
    }

    public function render()
    {
        switch ($this->renderMode) {
            case self::RENDER_MODE_HEAD;
                return $this->renderHead();
            case self::RENDER_MODE_FOOT:
                return $this->renderFoot();
            default:
                return $this->renderHead() 
                    . $this->templateRenderer->render('elements.tpl.php', array('elements' => $this->getElements()))
                    . $this->renderFoot();
        }
    }

    //! Returns an array of all the Elements found in this container.
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
