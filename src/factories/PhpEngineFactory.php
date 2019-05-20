<?php
namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\PhpEngine;
use ntentan\honam\engines\php\Janitor;

class PhpEngineFactory implements EngineFactoryInterface
{
    private $helperFactory;
    private $janitor;

    public function __construct(HelperFactory $helperFactory, Janitor $janitor)
    {
        $this->helperFactory = $helperFactory;
        $this->janitor = $janitor;
    }

    public function create(): AbstractEngine
    {
        return new PhpEngine($this->helperFactory, $this->janitor);
    }
}
