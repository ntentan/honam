<?php


namespace ntentan\honam;


use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use ntentan\honam\engines\PhpEngine;
use ntentan\honam\engines\MustacheEngine;

class Templates
{
    private $templateRenderer;
    private $templateFileResolver;

    public function __construct(TemplateFileResolver $templateFileResolver = null, TemplateRenderer $templateRenderer = null)
    {
        $engineRegistry = null;
        $this->templateFileResolver = $templateFileResolver ?? new TemplateFileResolver();
        $this->templateRenderer = $templateRenderer ?? new TemplateRenderer($engineRegistry = new EngineRegistry(), $templateFileResolver);
        if($engineRegistry) {
            $engineRegistry->registerEngine('mustache', new MustacheEngine());
            $engineRegistry->registerEngine('php.tpl', new PhpEngine());
        }
    }

    public function prependPath(string $path)
    {
        $this->templateFileResolver->prependToPathHierarchy($path);
    }

    public function appendPath(string $path)
    {
        $this->templateFileResolver->appendPath($path);
    }

    public function render(string $template, array $data)
    {
        return $this->templateRenderer->render($template, $data);
    }
}
