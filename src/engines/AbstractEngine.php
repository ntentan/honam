<?php

namespace ntentan\honam\engines;

use ntentan\honam\TemplateRenderer;

abstract class AbstractEngine
{
    /**
     * @var TemplateRenderer
     */
    protected $templateRenderer;

    public function setTemplateRenderer(TemplateRenderer $templateSystem)
    {
        $this->templateRenderer = $templateSystem;
    }

    /**
     * Passes the data to be rendered to the template engine instance.
     * @param string $filePath
     * @param array $data
     * @return string
     */
    abstract public function renderFromFileTemplate(string $filePath, array $data) : string;

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     * @param string $string
     * @param array $data
     * @return string
     */
    abstract public function renderFromStringTemplate(string $string, array $data) : string;
    
}