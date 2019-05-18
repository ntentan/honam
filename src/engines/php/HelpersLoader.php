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

use ReflectionMethod;

/**
 * A class for loading the helpers in views.
 */
class HelpersLoader
{
    private $loadedHelpers = array();
    
    /**
     * Get the instance of a helper given the string name of the helper.
     * 
     * @param string $helper
     * @return boolean|\ntentan\honam\Helper
     */
    private function getHelper($helper)
    {
        if(!isset($this->loadedHelpers[$helper])) {
            $helperClass = __NAMESPACE__ . "\\helpers\\" . ucfirst($helper) . "Helper";;
            $helperInstance = new $helperClass();
            $this->loadedHelpers[$helper] = $helperInstance;
        }
        return $this->loadedHelpers[$helper];
    }

    public function __get($helper)
    {
        return $this->getHelper($helper);
    }

    public function __call($helperName, $arguments)
    {
        $helper = $this->getHelper($helperName);;
        return (new ReflectionMethod($helper, 'help'))->invokeArgs($helper, $arguments);
    }
}
