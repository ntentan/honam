<?php
/**
 * The view class for dealing with views
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

namespace ntentan\honam;

use ntentan\honam\template_engines\TemplateEngine;

/**
 * The view class represents the main entry point for the honam template library.
 * A view contains a layout and a template. The layout is intended to remain
 * constant throughout several pages on your site. As its name suggests, it would
 * be the layout of the pages on your site. The template on the other hand helps 
 * render specific content for specific pages. Content rendered with templates 
 * are by default wrapped by the layout assigned to the view. Apart from templates,
 * layouts can also contain widgets which are in themselves tiny little embedded 
 * views.
 * 
 * @author ekow
 */
class View
{
    /**
     * A reference to the layout of this view.
     * @var string
     */
    private $layout;
    
    /**
     * A reference to the template of this view.
     * @var string
     */
    private $template;

    /**
     * Renders the output by loading and rendering the template files for the 
     * layout and the page template. 
     * 
     * @param array $viewData An associative array which represents the various
     *      variables assignable in the view.
     * @return string
     */
    public function out($viewData)
    {
        if($this->template == null)
        {
            $data = null;
        }
        else
        {
            $data = TemplateEngine::render($this->template, $viewData, $this);
        }

        if($this->layout == null)
        {
            $output = $data;
        }
        else
        {
            $viewData['contents'] = $data;
            $output = TemplateEngine::render($this->layout, $viewData, $this);
        }
        
        return $output;
    }
    
    /**
     * Sets a reference to the layout template.
     * 
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    
    /**
     * Sets a reference to the page template.
     * 
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    /**
     * Gets the reference to the page template.
     * 
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
