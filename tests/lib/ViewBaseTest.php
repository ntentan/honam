<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\EngineRegistry;
use ntentan\honam\engines\php\HelperFactory;
use ntentan\honam\engines\php\Janitor;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\factories\SmartyEngineFactory;
use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use PHPUnit\Framework\TestCase;
use ntentan\honam\engines\php\HelperVariable;

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
        $helpers = new HelperVariable(new HelperFactory(), $this->templateRenderer);
        $engineRegistry->registerEngine(['tpl.php'], new PhpEngineFactory($this->templateRenderer, $helpers, new Janitor()));
        $engineRegistry->registerEngine(["smarty", "tpl"], new SmartyEngineFactory());
        $this->templateFileResolver->appendToPathHierarchy(__DIR__ . "/../files/views");
    }
}
