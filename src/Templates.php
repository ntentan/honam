<?php
namespace ntentan\honam;

use ntentan\honam\engines\php\HelperFactory;
use ntentan\honam\factories\PhpEngineFactory;
use ntentan\honam\factories\MustacheEngineFactory;
use ntentan\honam\engines\php\HelperVariable;
use ntentan\honam\engines\php\Janitor;

/**
 * An access point to most of the functionality in honam
 */
class Templates
{
    /**
     * An instance of the template renderer for rendering templates.
     */
    private TemplateRenderer $templateRenderer;
    
    /**
     * An instance of the resolver that resolves template files for requests.
     */
    private TemplateFileResolver $templateFileResolver;

    public function __construct(TemplateFileResolver $templateFileResolver, TemplateRenderer $templateRenderer)
    {
        $this->templateFileResolver = $templateFileResolver;
        $this->templateRenderer = $templateRenderer;
    }

    public function prependPath(string $path): void
    {
        $this->templateFileResolver->prependToPathHierarchy($path);
    }

    public function appendPath(string $path): void
    {
        $this->templateFileResolver->appendToPathHierarchy($path);
    }

    public function render(string $template, array $data): string
    {
        return $this->templateRenderer->render($template, $data);
    }

    public static function getDefaultInstance(): Templates
    {
        $templateFileResolver = new TemplateFileResolver();
        $templateRenderer = new TemplateRenderer($engineRegistry = new EngineRegistry(), $templateFileResolver);
        $engineRegistry->registerEngine(['.mustache'], new MustacheEngineFactory($templateFileResolver));
        $helperFactory = new HelperFactory();
        $helperVariable = new HelperVariable($helperFactory, $templateRenderer);
        $engineRegistry->registerEngine(['.tpl.php'], new PhpEngineFactory($templateRenderer, $helperVariable, new Janitor()));
        return new Templates($templateFileResolver, $templateRenderer);
    }
}
