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

namespace ntentan\views;

/**
 * 
 */
class AssetsLoader
{
    private static $assetsBase = 'assets';
    private static $publicBase = 'public';
    
    public static function load($asset, $copyFrom = null)
    {
        $assetPath = ($copyFrom==null ? self::$assetsBase . "/$asset" : $copyFrom);
        $publicPath = self::$publicBase . "/$asset";
        $publicDirectory = dirname($publicPath);
        
        if(file_exists($publicPath)) 
        {
            return $publicPath;
        }
        
        if(file_exists($assetPath) && file_exists($publicDirectory) && is_writable($publicDirectory))
        {
            copy($assetPath, $publicPath);
        }
        else
        {
            self::throwTemplateEngineExceptions($assetPath, $publicPath);
        }
        return $publicPath;
    }
    
    private static function throwTemplateEngineExceptions($assetPath, $publicPath)
    {
        if(!file_exists($assetPath))
        {
            throw new \ntentan\views\exceptions\FileNotFoundException("File not found [$assetPath]");
        }
        else if(!is_writable($publicPath))
        {
            throw new \ntentan\views\exceptions\FilePermissionException("Destination [$publicPath] is not writable");
        }        
    }    
    
    public static function setSourceDir($assetsBase)
    {
        self::$assetsBase = $assetsBase;
    }
    
    public static function setDestinationDir($publicBase)
    {
        self::$publicBase = $publicBase;
    }    
    
    public static function getDestinationDir()
    {
        return self::$publicBase;
    }
}
