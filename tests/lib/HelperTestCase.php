<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\EngineRegistry;
use ntentan\honam\engines\php\Janitor;
use ntentan\honam\factories\HelperFactory;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use PHPUnit\Framework\TestCase;

class HelperTestCase extends TestCase
{
    protected $helpers;
    
    public function setUp() : void
    {
        error_reporting(E_ALL);
        $this->helpers = new HelperFactory();
        $templateFileResolver = new TemplateFileResolver();
        $engineRegistry = new EngineRegistry();
        $phpEngineFactory = new PhpEngineFactory($this->helpers, new Janitor());
        $engineRegistry->registerEngine(["tpl.php"], $phpEngineFactory);
        $this->helpers->setupTemplatePaths($templateFileResolver);
        $this->helpers->setTemplateRenderer(new TemplateRenderer($engineRegistry, $templateFileResolver));
    }
}
