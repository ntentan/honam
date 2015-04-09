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

namespace ntentan\views\widgets\pagination;
use ntentan\views\widgets\Widget;
use ntentan\Ntentan;

class PaginationWidget extends Widget
{
    private $pageNumber;
    private $numberOfPages;
    private $baseRoute;
    private $numberOfLinks;
    private $halfNumberOfLinks;
    private $query;

    public function init($params = null)
    {
        $this->pageNumber = is_object($params['page_number']) ? $params['page_number']->unescape() : $params['page_number'];
        $this->numberOfPages = $params['number_of_pages'];
        $this->baseRoute = $params['base_route'];
        $this->numberOfLinks = isset($params['number_of_links']) ? $params['number_of_links'] : 21;
        $this->halfNumberOfLinks = ceil($params['number_of_links'] / 2);
        $this->query = $params['query'];
        if($this->query != '')
        {
            $this->pageNumber = $_GET[$this->query] == '' ? 1 : $_GET[$this->query];
        }
    }
    
    
    private function getLink($index)
    {
        if($this->query == '')
        {
            $link = Ntentan::getUrl($this->baseRoute . $index);
        }
        else
        {
            $link = Ntentan::getUrl($this->baseRoute) . '?';
            foreach($_GET as $key => $value)
            {
                if($key == $this->query) continue;
                $link .= "$key=" . urlencode($value) . '&';
            }
            $link .= "{$this->query}=$index";
        }
        return $link;
    }

    public function execute()
    {
        if($this->pageNumber > 1)
        {
            $pagingLinks[] = array(
                "link" => $this->getLink($this->pageNumber - 1),
                "label" => "< Prev"
            );
        }

        if($this->numberOfPages <= $this->numberOfLinks || $this->pageNumber < $this->halfNumberOfLinks)
        {
            for($i = 1; $i <= ($this->numberOfPages > $this->numberOfLinks ? $this->numberOfLinks : $this->numberOfPages) ; $i++)
            {
                
                $pagingLinks[] = array(
                    "link" => $this->getLink($i),
                    "label" => "$i",
                    "selected" => $this->pageNumber == $i
                );
            }
        }
        else
        {
            if($this->numberOfPages - $this->pageNumber < $this->halfNumberOfLinks)
            {
                $startOffset = $this->pageNumber - (($this->numberOfLinks - 1) - ($this->numberOfPages - $this->pageNumber));
                $endOffset = $this->pageNumber + ($this->numberOfPages - $this->pageNumber);
            }
            else
            {
                $startOffset = $this->pageNumber - ($this->halfNumberOfLinks - 1);
                $endOffset = $this->pageNumber + ($this->halfNumberOfLinks - 1);
            }
            for($i = $startOffset ; $i <= $endOffset; $i++)
            {
                $pagingLinks[] = array(
                    "link" => $this->getLink($i),
                    "label" => "$i",
                    "selected" => $this->pageNumber == $i
                );
            }
        }

        if($this->pageNumber < $this->numberOfPages)
        {
            $pagingLinks[] = array(
                "link" => $this->getLink($this->pageNumber + 1),
                "label" => "Next >"
            );
        }
        
        $this->set("pages", $pagingLinks);
    }
}