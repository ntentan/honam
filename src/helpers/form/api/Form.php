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

namespace ntentan\views\helpers\form\api;

use ntentan\views\template_engines\TemplateEngine;
use ntentan\utils\Input;

/**
 * The form class. This class represents the overall form class. This
 * form represents the main form for collecting data from the user.
 */
class Form extends Container
{
    protected $submitValues = array('Submit');
    protected $showSubmit = true;
    protected $method = "POST";
    private $action;

    public function __construct()
    {
        parent::__construct();
        $this->action = Input::server("REQUEST_URI");
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    
    public function renderHead()
    {
        $this->setAttribute("method", $this->method);
        $this->setAttribute("class", "fapi-form");
        $this->setAttribute('action', $this->action);
        $this->setAttribute('accept-charset', 'utf-8');
        
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
    
    public function setShowSubmit($showSubmit)
    {
        $this->showSubmit = $showSubmit;
    }
    
    public function setSubmitValues($submitValues)
    {
        $this->submitValues = $submitValues;
    }
}
