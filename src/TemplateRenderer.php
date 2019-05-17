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

use ntentan\honam\exceptions\TemplateResolutionException;

/**
 * The TemplateEngine class does the work of resolving templates, loading template files,
 * loading template engines and rendering templates. The `ntentan/views` package takes a reference to a 
 * template and tries to find a specific template file to be used for the rendering. 
 * `ntentan/views` does not expect to find all view templates in a single directory.
 * It uses a heirachy of directories which it searches for the template to render.
 * Templates in directories closer to the beginning of the array have a higher
 * priority over those closer to the end of the array.
 * 
 */
class TemplateRenderer
{

    /**
     * An array of loaded template engine instances.
     * @var array<\ntentan\honam\TemplateEngine>
     */
    private $loadedInstances;

    /**
     * Instance of the engine registry for loading template engines.
     * @var EngineRegistry
     */
    private $registry;

    /**
     * Instance of the template file resolver for finding template files.
     * @var TemplateFileResolver
     */
    private $templateFileResolver;

    /**
     * TemplateRenderer constructor.
     *
     * @param EngineRegistry $registry
     */
    public function __construct(EngineRegistry $registry, TemplateFileResolver $templateFileResolver)
    {
        $this->registry = $registry;
        $this->templateFileResolver = $templateFileResolver;
        $registry->setTemplateRenderer($this);
    }

    /**
     * @return string|null
     */
    private function getTemplateExtension($templateFile)
    {
        foreach($this->registry->getSupportedExtensions() as $extension) {
            if($extension == substr($templateFile, -strlen($extension))) return $extension;
        }
        return null;
    }


    /**
     * Check if an engine exists that can render the given file.
     * @param $file
     * @return bool
     */
    public function canRender($templateFile)
    {
        return $this->getTemplateExtension($templateFile) !== null;
    }


    /**
     * Load and cache an instance of the a template engine.
     *
     * @param $extension
     * @return mixed
     * @throws exceptions\TemplateEngineNotFoundException
     */
    private function loadEngine($extension)
    {
        if(!isset($this->loadedInstances[$extension])) {
            $this->loadedInstances[$extension] = $this->registry->getEngineInstance($extension);
        }
        return $this->loadedInstances[$extension];
    }


    /**
     * Renders a given template reference with associated template data. This render
     * function combs through the template directory heirachy to find a template
     * file which matches the given template reference and uses it for the purpose
     * of rendering the view.
     * 
     * @param string $template The template reference file.
     * @param array $templateData The data to be passed to the template.
     * @return string
     * @throws \ntentan\honam\exceptions\FileNotFoundException
     */
    public function render($template, $data, $fromString = false, $extension=null)
    {
        if($fromString) {
            $engine = $this->loadEngine($extension);
            return $engine->renderFromFileTemplate($template, $data);
        } else {
            $templateFile = $this->templateFileResolver->resolveTemplateFile($template);
            $engine = $this->loadEngine($this->getTemplateExtension($templateFile));
            return $engine->renderFromFileTemplate($templateFile, $data);
        }
    }
}
