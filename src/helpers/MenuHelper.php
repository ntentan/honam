<?php
/**
 * Source file for the menu widget
 * 
 * Ntentan Framework
 * Copyright (c) 2010-2012 James Ekow Abaka Ainooson
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
 * @category Widgets
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright 2010-2012 James Ainooson
 * @license MIT
 */


namespace ntentan\honam\helpers;

use ntentan\honam\Helper;
use ntentan\utils\Input;

/**
 * Standard menu widget which ships with the menu widget.
 */
class MenuHelper extends Helper
{
    private $items = array();
    private $cssClasses = array();
    private $currentUrl;
    private $alias;
    private $hasLinks = true;
    
    public function __construct()
    {
        \ntentan\honam\TemplateEngine::appendPath(
            __DIR__ . "/../../templates/menu"
        );
        $this->setCurrentUrl(Input::server('REQUEST_URI'));
    }    

    public function help($items = null)
    {
        $this->items = $items;
        return $this;
    }
    
    public function addCssClass($class)
    {
        $this->cssClasses[] = $class;
        return $this;
    }
    
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }
    
    public function setCurrentUrl($currentUrl)
    {
        $this->currentUrl = $currentUrl;
        return $this;
    }
    
    public function setHasLinks($hasLinks)
    {
        $this->hasLinks = $hasLinks;
        return $this;
    }
    
    public function __toString()
    {
        $menuItems = array();
        
        foreach($this->items as $index => $item)
        {
            if(is_string($item) || is_numeric($item))
            {
                $item = array(
                    'label' => $item,
                    'url' => strtolower(str_replace(' ', '_', $item)),
                    'default' => null
                );
            }
            
            $item['selected'] = (
                $item['url'] == substr($this->currentUrl, 0, strlen($item['url']))
            );
            
            $item['fully_matched'] = $item['url'] == $this->currentUrl;
            
            $menuItems[$index] = $item;
        }
        
        return \ntentan\honam\TemplateEngine::render(
            'menu.tpl.php',
            [
                'items' => $menuItems,
                'css_classes' => $this->cssClasses,
                'has_links' => $this->hasLinks,
                'alias' => $this->alias 
            ]
        );
    }
}
