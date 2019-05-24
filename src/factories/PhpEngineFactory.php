<?php
namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\php\HelperVariable;
use ntentan\honam\engines\PhpEngine;
use ntentan\honam\engines\php\Janitor;
use ntentan\honam\TemplateRenderer;

class PhpEngineFactory implements EngineFactoryInterface
{
    private $helperFactory;
    private $janitor;
    private $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer, HelperVariable $helperFactory, Janitor $janitor)
    {
        $this->helperFactory = $helperFactory;
        $this->janitor = $janitor;
        $this->templateRenderer = $templateRenderer;
    }

    public function create(): AbstractEngine
    {
        return new PhpEngine($this->templateRenderer, $this->helperFactory, $this->janitor);
    }
}
