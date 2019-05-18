<?php


namespace ntentan\honam;


use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\exceptions\TemplateEngineNotFoundException;
use ntentan\honam\factories\EngineFactoryInterface;

class EngineRegistry
{
    private $engines = [];
    private $extensions = [];
    private $templateRenderer;

    public function setTemplateRenderer(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function registerEngine($extensions, $factory)
    {
        foreach($extensions as $extension) {
            $this->extensions[$extension] = $factory;
        }
    }

    public function getSupportedExtensions()
    {
        return array_keys($this->extensions);
    }

    public function getEngineInstance($templateFile) : AbstractEngine
    {
        foreach($this->extensions as $extension => $factory) {
            if($extension == substr($templateFile, -strlen($extension))) {
                if(is_a($factory, EngineFactoryInterface::class)) {
                    $engine = $factory->create($this->templateRenderer);
                } else if (is_callable($factory)) {
                    $engine = $factory($this->templateRenderer);
                } else {
                    throw new FactoryException("There is no factory for creating engines for the {$extension} extension");
                }
                $engine->setTemplateRenderer($this->templateRenderer);
                return $engine;
            }
        }

        throw new TemplateEngineNotFoundException("An engine for rendering the {$templateFile} extension was not found.");
    }
}
