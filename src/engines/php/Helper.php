<?php
/*
 * Ntentan Framework
 * Copyright (c) 2010-2012 James Ekow Abaka Ainooson
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

use ntentan\honam\TemplateRenderer;

/**
 * Base class for helpers. Helpers are little utilities that make it possible to perform repetitively routine tasks in
 * views.
 */
class Helper
{
    /**
     * The base url of the app. Used by helpers which need to build full URLS.
     * This variable is used in the Helper::makeFullUrl method.
     * @var string
     */
    private string $baseUrl;

    /**
     * Prefixes for URLS.
     * @var string
     */
    private string $prefix;

    protected TemplateRenderer $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * A sort of constructor or entry point for helpers.
     *
     * @param mixed $arguments
     * @return Helper
     */
    public function help(mixed $arguments): Helper
    {
        return $this;
    }
    
    /**
     * Set the base url used in the helpers.
     *
     * @param string $baseUrl The new base url
     * @param string $prefix The prefix to be used in url generation
     */
    public function setUrlParameters(string $baseUrl, string $prefix): void
    {
        $this->baseUrl = $baseUrl;
        $this->prefix = $prefix;
    }

    /**
     * Generate a full url by concatenating the base url with a path.
     *
     * @param string $url
     * @return string
     */
    protected function makeFullUrl(string $url = ''): string
    {
        return "{$this->prefix}/{$this->baseUrl}/$url";
    }

    /**
     * Get the base URL to be used by helpers that need the current URI.
     *
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function getPrefix(): string
    {
        return $this->prefix;
    }
}
