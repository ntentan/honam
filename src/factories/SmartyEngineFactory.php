<?php
namespace ntentan\honam\factories;

use ntentan\honam\factories\EngineFactoryInterface;
use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\PhpEngine;
use ntentan\honam\engines\php\HelperFactory;
use ntentan\honam\engines\php\Janitor;
use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;

class SmartyEngineFactory implements EngineFactoryInterface
{
    public function create(TemplateRenderer $templateRenderer): AbstractEngine
    {
        $helpersLoader = new HelperFactory($templateRenderer);
        $janitor = new Janitor();
        return new PhpEngine($helpersLoader, $janitor);
    }
}
