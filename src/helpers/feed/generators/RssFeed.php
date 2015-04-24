<?php
/* 
 * Ntentan Framework
 * Copyright (c) 2008-2015 James Ekow Abaka Ainooson
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
 */

namespace ntentan\views\helpers\feed\generators;

use ntentan\views\helpers\feed\Generator;

/**
 * RSS Feed generator for the Feed helper.
 */
class RssFeed extends Generator
{
    public function generate()
    {
        $rss = new \SimpleXMLElement('<rss></rss>');
        $rss['version'] = '2.0';
        $rss->addChild('channel');
        foreach($this->properties as $property => $value)
        {
            $property = $this->convertProperty($property);
            $rss->channel->addChild($property, $this->formatProperty($property, $value));
        }
        foreach($this->items as $item)
        {
            $itemElement = $rss->channel->addChild('item');
            foreach($item as $field => $value)
            {
                $value = utf8_encode($value);
                $property = $this->convertProperty($field);
                $itemElement->addChild($property, $this->formatProperty($property, $value));
            }
            if(!isset($item['id']))
            {
                $this->getGUID($itemElement, $item);
            }
        }
        return $rss->asXML();
    }
    
    private function getGUID($itemElement, $item)
    {
        if(isset($item['url']))
        {
            $itemElement->addChild('guid', $item['url']);
            $itemElement->guid['isPermaLink'] = 'true';
        }
        else
        {
            $itemElement->addChild('guid', md5(serialize($item)));
            $itemElement->guid['isPermaLink'] = 'false';
        }        
    }
    
    /**
     * Convert generic feed properties to the ones specified in the RSS 
     * standard.
     * 
     * @param string $property
     * @return string
     */
    private function convertProperty($property)
    {
        $properties = array(
            'title' => 'title',
            'url' => 'link',
            'updated' => 'lastBuildDate',
            'summary' => 'description',
            'author' => 'author',
            'category' => 'category',
            'date' => 'pubDate',
            'id' => 'guid',
            'description' => 'description'
        );
        
        return $properties[$property];
    }
    
    private function formatProperty($property, $value)
    {
        switch($property)
        {
            case 'lastBuildDate':
            case 'pubDate':
                return date("r", strtotime($value));
            default:
                return $value;
        }
    }
}
