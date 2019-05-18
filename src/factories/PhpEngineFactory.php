<?php
namespace ntentan\honam\factories;

use ntentan\honam\factories\EngineFactoryInterface;
use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\PhpEngine;
use ntentan\honam\engines\php\HelperFactory;
use ntentan\honam\engines\php\Janitor;
use ntentan\honam\Honam;
use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;

class PhpEngineFactory implements EngineFactoryInterface
{
    public function __construct(TemplateFileResolver $templateFileResolver)
    {
        $templateFileResolver->appendToPathHierarchy(__DIR__ . "/../../templates/forms");
        $templateFileResolver->appendToPathHierarchy(__DIR__ . "/../../templates/lists");
    }

    public function create(TemplateRenderer $templateRenderer): AbstractEngine
    {
        $helpersLoader = new HelperFactory($templateRenderer);
        $janitor = new Janitor();
        return new PhpEngine($helpersLoader, $janitor);
    }
}
