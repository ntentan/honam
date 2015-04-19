<?php
/**
 * Common utilities file for the Ntentan framework. This file contains a 
 * collection of utility static methods which are used accross the framework.
 * 
 * Ntentan Framework
 * Copyright (c) 2008-2014 James Ekow Abaka Ainooson
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
 * @copyright Copyright 2014 James Ekow Abaka Ainooson
 * @license MIT
 */

namespace ntentan\views\helpers\pagination;

use ntentan\views\helpers\Helper;
use ntentan\views\template_engines\TemplateEngine;
use ntentan\utils\Input;

class PaginationHelper extends Helper
{
    /*private $pageNumber;
    private $numberOfPages;
    private $baseRoute;
    private $numberOfLinks;
    private $query;*/
    
    private $parameters = array(
        'query' => null,
        'number_of_links' => 21,
        'number_of_pages' => null,
        'base_url' => null,
        'page_number' => 1
    );
    private $halfNumberOfLinks;
    
    public function __construct()
    {
        \ntentan\views\template_engines\TemplateEngine::appendPath(
            __DIR__ . "/../../../templates/pagination"
        );
    } 

    public function help($params = array())
    {
        $this->parameters = array_merge($this->parameters, $params);
        $this->halfNumberOfLinks = ceil($this->parameters['number_of_links'] / 2);
        if($this->parameters['query'] != '')
        {
            $this->parameters['page_number'] = Input::get($this->parameters['query']) == '' ? 1 : Input::get($this->parameters['query']);
        }
        return $this;
    }
    
    
    private function getLink($index)
    {
        if($this->parameters['query'] == '')
        {
            $link = $this->parameters['base_url'] . $index;
        }
        else
        {
            $link = $this->parameters['base_url'] . '?';
            $get = Input::get();
            foreach($get as $key => $value)
            {
                if($key == $this->parameters['query']) continue;
                $link .= "$key=" . urlencode($value) . '&';
            }
            $link .= "{$this->parameters['query']}=$index";
        }
        return $link;
    }

    public function __toString()
    {
        $pagingLinks = array();
        if($this->parameters['page_number']> 1)
        {
            $pagingLinks[] = array(
                "link" => $this->getLink($this->parameters['page_number']- 1),
                "label" => "< Prev",
                "selected" => false
            );
        }

        if($this->parameters['number_of_pages'] <= $this->parameters['number_of_links'] || $this->parameters['page_number']< $this->halfNumberOfLinks)
        {
            for($i = 1; $i <= ($this->parameters['number_of_pages'] > $this->parameters['number_of_links'] ? $this->parameters['number_of_links'] : $this->parameters['number_of_pages']) ; $i++)
            {
                
                $pagingLinks[] = array(
                    "link" => $this->getLink($i),
                    "label" => "$i",
                    "selected" => $this->parameters['page_number']== $i
                );
            }
        }
        else
        {
            if($this->parameters['number_of_pages'] - $this->parameters['page_number']< $this->halfNumberOfLinks)
            {
                $startOffset = $this->parameters['page_number']- (($this->parameters['number_of_links'] - 1) - ($this->parameters['number_of_pages'] - $this->parameters['page_number']));
                $endOffset = $this->parameters['page_number']+ ($this->parameters['number_of_pages'] - $this->parameters['page_number']);
            }
            else
            {
                $startOffset = $this->parameters['page_number']- ($this->halfNumberOfLinks - 1);
                $endOffset = $this->parameters['page_number']+ ($this->halfNumberOfLinks - 1);
            }
            for($i = $startOffset ; $i <= $endOffset; $i++)
            {
                $pagingLinks[] = array(
                    "link" => $this->getLink($i),
                    "label" => "$i",
                    "selected" => $this->parameters['page_number']== $i
                );
            }
        }

        if($this->parameters['page_number']< $this->parameters['number_of_pages'])
        {
            $pagingLinks[] = array(
                "link" => $this->getLink($this->parameters['page_number']+ 1),
                "label" => "Next >",
                "selected" => false
            );
        }
        
        return TemplateEngine::render("links.tpl.php", array('links' => $pagingLinks));
    }
}
