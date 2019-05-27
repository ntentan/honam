<?php
namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\SmartyEngine;
use ntentan\honam\engines\smarty\Core;

class SmartyEngineFactory implements EngineFactoryInterface
{
    private $tempDirectory;

    public function __construct(string $tempDirectory = '.tmp')
    {
        $this->tempDirectory = $tempDirectory;
    }

    public function create(): AbstractEngine
    {
        return new SmartyEngine(new Core($this->tempDirectory));
    }
}
