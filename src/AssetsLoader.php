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

namespace ntentan\honam;

/**
 * 
 */
class AssetsLoader
{
    private static $assetsPathHeirachy = [];
    private static $publicPath = 'public';
    private static $siteUrl = null;
    
    public static function getAssetPath($asset)
    {
        $path = '';
        foreach(self::$assetsPathHeirachy as $assetPath)
        {
            if(file_exists("$assetPath/$asset"))
            {
                $path = "$assetPath/$asset";
            }
        }
        
        if($path == '')
        {
            throw new exceptions\FileNotFoundException("Asset file $asset not found");
        }
        
        return $path;
    }
    
    public static function load($asset, $copyFrom = null)
    {
        if($copyFrom === null)
        {
            $assetPath = self::getAssetPath($asset);
        }
        else
        {
            $assetPath = $copyFrom;
        }
        
        $publicPath = self::$publicPath . "/$asset";
        $publicDirectory = dirname($publicPath);
        
        if(file_exists($assetPath) && file_exists($publicDirectory) && is_writable($publicDirectory))
        {
            copy($assetPath, $publicPath);
        }
        else
        {
            self::throwTemplateEngineExceptions($assetPath, $publicPath);
        }
        return self::getSiteUrl() . "/$asset";
    }
    
    private static function throwTemplateEngineExceptions($assetPath, $publicPath)
    {
        if(!file_exists($assetPath))
        {
            throw new \ntentan\honam\exceptions\FileNotFoundException("File not found [$assetPath]");
        }
        else if(!is_writable($publicPath))
        {
            throw new \ntentan\honam\exceptions\FilePermissionException("Destination [$publicPath] is not writable");
        }        
    }    
    
    public static function appendSourceDir($assetsDir)
    {
        self::$assetsPathHeirachy[] = $assetsDir;
    }
    
    public static function prependSourceDir($assetsDir)
    {
        array_unshift(self::$assetsPathHeirachy, $assetsDir);
    }
    
    public static function setDestinationDir($publicBase)
    {
        self::$publicPath = $publicBase;
    }    
    
    public static function getDestinationDir()
    {
        return self::$publicPath;
    }
    
    /**
     * Returns the base url of the current site.
     * Used internally mainly for the purposes of generating HTML files, this
     * function would either return a preset site URL or the current 
     * destination directory. Using this function makes it easy to generate
     * HTML files which depend on relative paths to locate assets.
     * 
     * @return string
     */
    public static function getSiteUrl()
    {
        if(self::$siteUrl === null)
        {
            return self::getDestinationDir();
        }
        else
        {
            return self::$siteUrl;
        }
    }
    
    public static function setSiteUrl($siteUrl)
    {
        self::$siteUrl = $siteUrl;
    }
    
    public static function reset()
    {
        self::$assetsPathHeirachy = [];
    }
}
