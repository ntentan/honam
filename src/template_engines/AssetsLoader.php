<?php
namespace ntentan\honam\template_engines;

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
            throw new \ntentan\honam\exceptions\FileNotFoundException("File not found [$assetPath]");
        }
        else if(!is_writable($publicPath))
        {
            throw new \ntentan\honam\exceptions\FilePermissionException("Destination [$publicPath] is not writable");
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
}
