<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\EngineRegistry;
use ntentan\honam\engines\php\Janitor;
use ntentan\honam\factories\HelperVariable;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\factories\SmartyEngineFactory;
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
        error_reporting(E_ALL);
        $this->templateFileResolver = new TemplateFileResolver();
        $engineRegistry = new EngineRegistry();
        $this->templateRenderer = new TemplateRenderer($engineRegistry, $this->templateFileResolver);
        $helpers = new \ntentan\honam\engines\php\HelperVariable($this->templateRenderer, $this->templateFileResolver);
        $engineRegistry->registerEngine(['tpl.php'], new PhpEngineFactory($this->templateRenderer, $helpers, new Janitor()));
        $engineRegistry->registerEngine(["smarty", "tpl"], new SmartyEngineFactory());
        $this->templateFileResolver->appendToPathHierarchy(__DIR__ . "/../files/views");

//        $this->templateFileResolver = new TemplateFileResolver();
//        $engineRegistry = new EngineRegistry();
//        $helperFactory = new HelperVariable();
//        $phpEngineFactory = new PhpEngineFactory($helperFactory, new Janitor());
//        $smartyEnginefactory = new SmartyEngineFactory($helperFactory, "/tmp");
//        $engineRegistry->registerEngine(["tpl.php"], $phpEngineFactory);
//        $engineRegistry->registerEngine(["smarty", "tpl"], $smartyEnginefactory);
//        $this->templateFileResolver->appendToPathHierarchy(__DIR__ . "/../files/views");
//        $this->templateRenderer = new TemplateRenderer($engineRegistry, $this->templateFileResolver);
//        $helperFactory->setTemplateRenderer($this->templateRenderer);
//        $helperFactory->setupTemplatePaths($this->templateFileResolver);
    }
}
