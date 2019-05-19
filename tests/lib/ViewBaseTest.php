<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\EngineRegistry;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use PHPUnit\Framework\TestCase;

class ViewBaseTest extends  TestCase
{
    protected $view;

    /**
     * @var TemplateRenderer
     */
    protected $templateRenderer;

    /**
     * @var TemplateFileResolver
     */
    protected $templateFileResolver;

    public function setUp() : void
    {
        $this->templateFileResolver = new TemplateFileResolver();
        $engineRegistry = new EngineRegistry();
        $phpEngineFactory = new PhpEngineFactory($this->templateFileResolver);
        $engineRegistry->registerEngine(["tpl.php"], $phpEngineFactory);
        $engineRegistry->registerEngine(["smarty", "tpl"], $phpEngineFactory);
        $this->templateFileResolver->appendToPathHierarchy(__DIR__ . "/../files/views");
        $this->templateRenderer = new TemplateRenderer($engineRegistry, $this->templateFileResolver);
    }
}
