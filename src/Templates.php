<?php
namespace ntentan\honam;

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
     * @var TemplateRenderer
     */
    private $templateRenderer;
    
    /**
     * An instance of the resolver that resolves template files for requests.
     * @var TemplateFileResolver
     */
    private $templateFileResolver;
    
    /**
     * An instance of the engine registry for loading template engines.
     * This engine registry is only used when an external template renderer is not supplied.
     * 
     * @var EngineRegistry
     */
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
