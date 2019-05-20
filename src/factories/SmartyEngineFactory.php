<?php
namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\SmartyEngine;
use ntentan\honam\engines\smarty\Core;

class SmartyEngineFactory implements EngineFactoryInterface
{
    private $tempDirectory;
    private $helperFactory;

    public function __construct(HelperFactory $helperFactory, string $tempDirectory)
    {
        $this->helperFactory = $helperFactory;
        $this->tempDirectory = $tempDirectory;
    }

    public function create(): AbstractEngine
    {
        return new SmartyEngine(new Core($this->helperFactory, $this->tempDirectory));
    }
}
