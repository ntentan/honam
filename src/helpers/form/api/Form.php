<?php
/**
 * Renders a form
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
 * @copyright Copyright 2010, 2015 James Ekow Abaka Ainooson
 * @license MIT
 */

namespace ntentan\honam\helpers\form\api;

use ntentan\honam\template_engines\TemplateEngine;

/**
 * The form class. This class represents the overall form class. This
 * form represents the main form for collecting data from the user.
 */
class Form extends Container
{
    protected $submitValues = array();
    protected $showSubmit = true;
    protected $method = "POST";
    private $action;
    
    private static $numForms;

    public function __construct($id="", $method="POST")
    {
        $this->setId($id);
        $this->method = $method;
        if(isset($_SERVER['REQUEST_URI']))
        {
            $this->action = $_SERVER["REQUEST_URI"];
        }
    }

    public function action($action)
    {
        $this->action = $action;
        return $this;
    }
    
    public function renderHead()
    {
        $this->addAttribute("method", $this->method);
        $this->addAttribute("id", $this->id());
        $this->addAttribute("class", "fapi-form");
        $this->addAttribute('action', $this->action);
        $this->addAttribute('accept-charset', 'utf-8');
        
        return TemplateEngine::render('form_head.tpl.php', array('element' => $this));
    }

    public function renderFoot()
    {
        return TemplateEngine::render('form_foot.tpl.php',
            array(
                'show_submit' => $this->showSubmit,
                'submit_values' => $this->submitValues,
            )
        );
    }

    public function setShowFields($show_field)
    {
        Container::setShowField($show_field);
        $this->setShowSubmit($show_field);
    }

    public function setId($id)
    {
        parent::id($id == "" ? "form" . Form::$numForms++ : $id);
        return $this;
    }
    
    public function setShowSubmit($showSubmit)
    {
        $this->showSubmit = $showSubmit;
    }
    
    public function setSubmitValues($submitValues)
    {
        $this->submitValues = $submitValues;
    }
}
