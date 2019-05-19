<?php
namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\SmartyEngine;
use ntentan\honam\engines\smarty\Core;
use ntentan\honam\TemplateRenderer;

class SmartyEngineFactory implements EngineFactoryInterface
{
    public function create(TemplateRenderer $templateRenderer): AbstractEngine
    {
        $helperFactory = new HelperFactory();
        $helperFactory->setTemplateRenderer($templateRenderer);
        return new SmartyEngine(new Core($helperFactory, $templateRenderer->getTempDirectory()));
    }
}
