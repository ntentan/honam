<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\EngineRegistry;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\TemplateEngine;
use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use PHPUnit\Framework\TestCase;

class ViewBaseTest extends  TestCase
{
    protected $view;
    protected $templateRenderer;
    protected $templateFileResolver;
    
    public function setUp() : void
    {
        $this->templateFileResolver = new TemplateFileResolver();
        $engineRegistry = new EngineRegistry();
        $phpEngineFactory = new PhpEngineFactory($this->templateFileResolver);
        $engineRegistry->registerEngine(["tpl.php"], $phpEngineFactory);
        $this->templateRenderer = new TemplateRenderer($engineRegistry, $this->templateFileResolver);
    }
}
