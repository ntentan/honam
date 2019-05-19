<?php
namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\PhpEngine;
use ntentan\honam\TemplateRenderer;

class SmartyEngineFactory implements EngineFactoryInterface
{
    public function create(TemplateRenderer $templateRenderer): AbstractEngine
    {
        return new smarty\Engine();
    }
}
