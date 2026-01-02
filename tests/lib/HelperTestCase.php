<?php
namespace ntentan\honam\tests\lib;

use ntentan\honam\EngineRegistry;
use ntentan\honam\engines\php\HelperFactory;
use ntentan\honam\engines\php\HelperVariable;
use ntentan\honam\engines\php\Janitor;
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
        $templateFileResolver = new TemplateFileResolver();
        $engineRegistry = new EngineRegistry();
        $templateRenderer = new TemplateRenderer($engineRegistry, $templateFileResolver);
        $this->helpers = new HelperVariable(new HelperFactory(), $templateRenderer);
        $engineRegistry->registerEngine(['tpl.php'], new PhpEngineFactory($templateRenderer, $this->helpers, new Janitor()));
    }
}
