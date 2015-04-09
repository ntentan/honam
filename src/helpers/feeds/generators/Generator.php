<?php
namespace ntentan\honam\helpers\feeds\generators;

abstract class Generator
{
    protected $properties;
    protected $items = array();

    public function setup($properties, $items)
    {
        $this->items = $items;
        $this->properties = $properties;
    }

    public abstract function execute();
}