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
 * Responsible for loading assets, placing them in a common directory and
 * could perform CDN url operations if needed.
 * This class employs a heirachy of directories from which assets are loaded.
 * Assets found in directories higher in the heirachy are chosen first. This
 * mechanism provides room for third party extensions to override assets provided
 * by core applications.
 */
class AssetsLoader
{
    /**
     * Heirachy of directories within which assets are loaded.
     * @var array
     */
    private static $assetsPathHeirachy = [];
    
    /**
     * Destination public directory of all loaded assets.
     * @var string
     */
    private static $publicPath = 'public';
    
    /*
     * Base site URL.
     * @var string
     */
    private static $siteUrl = null;
    
    /**
     * Returns the actual path for a particular asset.
     * You pass a specific asset destination path to this method and it 
     * scans the asset path till it finds a matching source asset. The path to
     * this matching asset is then returned.
     * 
     * @param string $asset
     * @return string
     * @throws exceptions\FileNotFoundException
     */
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
    
    /**
     * Loads an asset into the public directory.
     * This method returns the site url path appended with the asset path.
     * 
     * @param string $asset Asset path
     * @param string $copyFrom Path to copy files from
     * @return 
     */
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
    
    /**
     * Append a source directory to the bottom of the heirachy.
     * @param string $assetsDir
     */
    public static function appendSourceDir($assetsDir)
    {
        self::$assetsPathHeirachy[] = $assetsDir;
    }
    
    /**
     * Prepend a source directory to the top of the heirachy.
     * @param string $assetsDir
     */
    public static function prependSourceDir($assetsDir)
    {
        array_unshift(self::$assetsPathHeirachy, $assetsDir);
    }
    
    /**
     * Set the destination directory of loaded assets.
     * @param string $publicBase
     */
    public static function setDestinationDir($publicBase)
    {
        self::$publicPath = $publicBase;
    }    
    
    /**
     * Get the destination directory of loaded assets.
     * @return string
     */
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
    
    /**
     * Set the base URL of your site to aid in generating full URLs for assets.
     * @param string $siteUrl
     */
    public static function setSiteUrl($siteUrl)
    {
        self::$siteUrl = $siteUrl;
    }
    
    public static function reset()
    {
        self::$assetsPathHeirachy = [];
    }
}
