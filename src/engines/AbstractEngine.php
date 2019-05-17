<?php

namespace ntentan\honam\engines;

use ntentan\honam\TemplateRenderer;

abstract class AbstractEngine
{
    /**
     * @var TemplateRenderer
     */
    protected $templateRenderer;

    public function setTemplateRenderer(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }
    
    /**
     * Passes the data to be rendered to the template engine instance.
     */
    abstract public function renderFromFileTemplate(string $filePath, array $data) : string;

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     */
    abstract public function renderFromStringTemplate(string $string, array $data) : string;
    
}