<?php

/*
 * View Templating System
 * Copyright (c) 2008-2015 James Ekow Abaka Ainooson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 */

namespace ntentan\honam;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\exceptions\TemplateEngineNotFoundException;
use ntentan\honam\exceptions\TemplateResolutionException;

/**
 * The TemplateEngine class does the work of resolving templates, loading template files, loading template engines and
 * rendering templates. The `ntentan/views` package takes a reference to a template and tries to find a specific
 * template file to be used for the rendering. `ntentan/views` does not expect to find all view templates in a single
 * directory. It uses a heirachy of directories which it searches for the template to render. Templates in directories
 * closer to the beginning of the array have a higher priority over those closer to the end of the array.
 */
class TemplateRenderer
{

    /**
     * An array of loaded template engine instances.
     * @var array<AbstractEngine>
     */
    private array $loadedInstances;

    /**
     * Instance of the engine registry for loading template engines.
     * @var EngineRegistry
     */
    private EngineRegistry $registry;

    /**
     * Instance of the template file resolver for finding template files.
     * @var TemplateFileResolver
     */
    private TemplateFileResolver $templateFileResolver;

    private string $tempDirectory;

    /**
     * TemplateRenderer constructor.
     *
     * @param EngineRegistry $registry
     * @param TemplateFileResolver $templateFileResolver
     */
    public function __construct(EngineRegistry $registry, TemplateFileResolver $templateFileResolver)
    {
        $this->registry = $registry;
        $this->templateFileResolver = $templateFileResolver;
        $this->tempDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "honam_temp";
    }

    /**
     * @param $templateFile
     * @return string|null
     * @throws TemplateEngineNotFoundException
     */
    private function getTemplateExtension(string $templateFile): string
    {
        $supportedExtensions = $this->registry->getSupportedExtensions();
        foreach($supportedExtensions as $extension) {
            if(str_ends_with($templateFile, $extension)) return $extension;
        }
        throw new TemplateEngineNotFoundException("There are currently no registered engines that can render $templateFile");
    }


    /**
     * Check if an engine exists that can render the given file.
     *
     * @param $templateFile
     * @return bool
     * @throws TemplateEngineNotFoundException
     */
    public function canRender(string $templateFile): bool
    {
        try {
            $this->getTemplateExtension($templateFile);
            return true;
        } catch(TemplateEngineNotFoundException $exception) {
            return false;
        }
    }

    /**
     * Load and cache an instance of a template engine.
     *
     * @return mixed
     * @throws exceptions\TemplateEngineNotFoundException
     * @throws exceptions\FactoryException
     */
    private function loadEngine(string $extension): AbstractEngine
    {
        if(!isset($this->loadedInstances[$extension])) {
            $this->loadedInstances[$extension] = $this->registry->getEngineInstance($extension);
        }
        return $this->loadedInstances[$extension];
    }

    public function setTempDirectory(string $tempDirectory): void
    {
        $this->tempDirectory = $tempDirectory;
    }

    /**
     * Renders a given template reference with associated template data. This render function combs through the template
     * directory heirachy to find a template file which matches the given template reference and uses it for the purpose
     * of rendering the view.
     *
     * @param string $template The template reference file.
     * @param $data
     * @param bool $fromString
     * @param string $extension
     * @return string
     * @throws TemplateResolutionException
     * @throws exceptions\TemplateEngineNotFoundException
     * @throws exceptions\FactoryException
     */
    public function render(string $template, array  $data, bool $fromString = false, string $extension=''): string
    {
        if($fromString) {
            $engine = $this->loadEngine($extension);
            return $engine->renderFromStringTemplate($template, $data);
        } else {
            $templateFile = $this->templateFileResolver->resolveTemplateFile($template);
            $engine = $this->loadEngine($this->getTemplateExtension($templateFile));
            return $engine->renderFromFileTemplate($templateFile, $data);
        }
    }
}
