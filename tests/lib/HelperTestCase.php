<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\EngineRegistry;
use ntentan\honam\engines\php\HelperFactory;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use PHPUnit\Framework\TestCase;

class HelperTestCase extends TestCase
{
    protected $helpers;
    
    public function setUp() : void
    {
        $templateFileResolver = new TemplateFileResolver();
        $engineRegistry = new EngineRegistry();
        $phpEngineFactory = new PhpEngineFactory($templateFileResolver);
        $engineRegistry->registerEngine(["tpl.php"], $phpEngineFactory);
        $this->helpers = new HelperFactory();
        $this->helpers->setTemplateRenderer(new TemplateRenderer($engineRegistry, $templateFileResolver));
    }
}
