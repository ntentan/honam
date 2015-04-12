<?php
namespace ntentan\honam\helpers\feed;

use ntentan\honam\helpers\Helper;

class FeedHelper extends Helper
{
    private $items;
    private $properties = array();
    private $format = 'rss';
    
    public function help($items)
    {
        $this->items = $items;
        return $this;
    }

    public function items($items)
    {
        $this->items = $items;
        return $this;
    }
    
    public function title($title)
    {
        $this->properties['title'] = $title;
        return $this;
    }
    
    public function url($url)
    {
        $this->properties['url'] = $url;
        return $this;
    }
    
    public function updated($updated)
    {
        $this->properties['updated'] = $updated;
        return $this;
    }
    
    public function description($desccription)
    {
        $this->properties['description'] = $desccription;
        return $this;
    }

    public function __toString()
    {
        $generatorClassName = ucfirst($this->format) . "Feed";
        $generatorClass = "\\ntentan\\honam\\helpers\\feed\\generators\\{$this->format}\\$generatorClassName";
        $generator = new $generatorClass();
        $generator->setup($this->properties, $this->items);
        return $generator->generate();
    }
}
