<?php
namespace ntentan\honam\engines\php\helpers\feed;

abstract class Generator
{
    protected $properties;
    protected $items = array();

    public function setup($properties, $items)
    {
        $this->items = $items;
        $this->properties = $properties;
    }

    abstract public function generate() : string;
}