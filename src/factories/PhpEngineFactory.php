<?php
namespace ntentan\honam\factories;

use ntentan\honam\factories\EngineFactoryInterface;
use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\PhpEngine;
use ntentan\honam\engines\php\HelpersLoader;
use ntentan\honam\engines\php\Janitor;

class PhpEngineFactory implements EngineFactoryInterface
{
    public function create(): AbstractEngine
    {
        $helpersLoader = new HelpersLoader();
        $janitor = new Janitor();
        return new PhpEngine($helpersLoader, $janitor);
    }
}
