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

namespace ntentan\honam;

/**
 * Base class for helpers. Helpers are little utilities that make it possible to
 * perform repetitively routine tasks in views.
 */
class Helper
{
    /**
     * The base url of the app. Used by helpers which need to build full URLS.
     * This variable is used in the Helper::makeFullUrl method.
     * @var string
     */
    private static $baseUrl;
    
    /**
     * A sort of constructor or entry point for helpers.
     * @param mixed $arguments
     * @return \ntentan\honam\Helper
     */
    public function help($arguments)
    {
        return $this;
    }
    
    /**
     * Set the base url used in the helpers.
     * @param string $url The new base url
     */
    public static function setBaseUrl($url)
    {
        self::$baseUrl = $url;
    }
    
    /**
     * Generate a full url by concatenating the base url with a path.
     * 
     * @param string $url
     * @return string
     */
    protected function makeFullUrl($url)
    {
        return preg_replace("~/+~", "/", self::$baseUrl . "/$url");
    }
}
