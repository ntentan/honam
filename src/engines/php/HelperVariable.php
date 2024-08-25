<?php
/*
 * Ntentan Framework
 * Copyright (c) 2010-2015 James Ekow Abaka Ainooson
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

namespace ntentan\honam\engines\php;

use ntentan\honam\TemplateFileResolver;
use ntentan\honam\TemplateRenderer;
use ReflectionMethod;

/**
 * A class for loading the helpers in views.
 */
class HelperVariable
{
    /**
     * A list of all helpers that have been loaded.
     * @var array
     */
    private array $loadedHelpers = array();

    /**
     * An instance of the template renderer.
     * @var TemplateRenderer
     */
    private TemplateRenderer $templateRenderer;

    /**
     * The current path being rendered.
     * @var string
     */
    private string $baseUrl = '/';

    /**
     * A prefix for the current URL to be prefixed or used by helpers.
     * @var string
     */
    private string $prefix = '';

    /**
     * Create a new instance of the helper variable.
     * @param TemplateRenderer $templateRenderer
     * @param TemplateFileResolver $templateFileResolver
     */
    public function __construct(TemplateRenderer $templateRenderer, TemplateFileResolver $templateFileResolver)
    {
        $templateFileResolver->appendToPathHierarchy(__DIR__ . "/../../../templates/forms");
        $templateFileResolver->appendToPathHierarchy(__DIR__ . "/../../../templates/lists");
        $templateFileResolver->appendToPathHierarchy(__DIR__ . "/../../../templates/menu");
        $templateFileResolver->appendToPathHierarchy(__DIR__ . "/../../../templates/pagination");
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * Get the instance of a helper given the string name of the helper.
     * 
     * @param string $helperName
     * @return boolean|Helper
     */
    private function getHelper(string $helperName) : Helper
    {
        if(!isset($this->loadedHelpers[$helperName])) {
            $helperClass = 'ntentan\honam\engines\php\helpers\\' . ucfirst($helperName) . "Helper";;
            $helperInstance = new $helperClass($this->templateRenderer);
            $helperInstance->setUrlParameters($this->baseUrl, $this->prefix);
            $this->loadedHelpers[$helperName] = $helperInstance;
        }
        return $this->loadedHelpers[$helperName];
    }

    public function __get($helper)
    {
        return $this->getHelper($helper);
    }

    /**
     * @param $helperName
     * @param $arguments
     * @return mixed
     * @throws \ReflectionException
     */
    public function __call($helperName, $arguments)
    {
        $helper = $this->getHelper($helperName);;
        return (new ReflectionMethod($helper, 'help'))->invokeArgs($helper, $arguments);
    }

    public function setUrlParameters(string $baseUrl, string $prefix): void
    {
        $this->baseUrl = $baseUrl;
        $this->prefix = $prefix;
    }
}
