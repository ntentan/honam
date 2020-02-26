<?php


namespace ntentan\honam;


use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\factories\MustacheEngineFactory;
use ntentan\honam\engines\php\HelperVariable;
use ntentan\honam\engines\php\Janitor;

class Templates
{
    private $templateRenderer;
    private $templateFileResolver;
    private $engineRegistry;

    public function __construct(TemplateFileResolver $templateFileResolver = null, TemplateRenderer $templateRenderer = null)
    {
        $this->templateFileResolver = $templateFileResolver ?? new TemplateFileResolver();
        $this->templateRenderer = $templateRenderer ?? new TemplateRenderer($this->engineRegistry = new EngineRegistry(), $this->templateFileResolver);
        if($this->engineRegistry) {
            $this->engineRegistry->registerEngine(['.mustache'], new MustacheEngineFactory($this->templateFileResolver));
            $helperVariable = new HelperVariable($this->templateRenderer, $this->templateFileResolver);
            $this->engineRegistry->registerEngine(['.tpl.php'], new PhpEngineFactory($this->templateRenderer, $helperVariable, new Janitor()));
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
