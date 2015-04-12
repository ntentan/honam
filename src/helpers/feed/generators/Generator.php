<?php
namespace ntentan\honam\helpers\feed\generators;

abstract class Generator
{
    protected $properties;
    protected $items = array();

    public function setup($properties, $items)
    {
        $this->items = $items;
        $this->properties = $properties;
    }

    abstract public function generate();
}