<?php
namespace ntentan\honam\template_engines;

abstract class TemplateEngine
{
    private static $loadedInstances;
    protected $template;
    private $widgetsLoader;
    private $helpersLoader;
    private static $path = array();
    private static $assetsBase = 'assets';
    private static $publicBase = 'public';

    public static function appendPath($path)
    {
        self::$path[] = $path;
    }

    public static function prependPath($path)
    {
        array_unshift(self::$path, $path);
    }

    public static function getPath()
    {
        return self::$path;
    }

    private static function getEngineInstance($template)
    {
    	$last = explode(".", $template);
        $engine = end($last);
        if(!isset(TemplateEngine::$loadedInstances[$engine]))
        {
            $engineClass = "ntentan\\honam\\template_engines\\$engine\\" . ucfirst($engine);
            if(class_exists($engineClass))
            {
                $engineInstance = new $engineClass();
            }
            else
            {
                throw new \ntentan\honam\exceptions\TemplateEngineNotFoundException("Could not load template engine class [$engineClass] for $template");
            }
            TemplateEngine::$loadedInstances[$engine] = $engineInstance;
        }
        TemplateEngine::$loadedInstances[$engine]->template = $template;
        return TemplateEngine::$loadedInstances[$engine];
    }

    public static function loadAsset($asset, $copyFrom = null)
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
    
    private function throwTemplateEngineExceptions($assetPath, $publicPath)
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

    public function __get($property)
    {
        $loader = null;
        
        switch($property)
        {
            case "widgets":
                if($this->widgetsLoader == null)
                {
                    $this->widgetsLoader = new WidgetsLoader();
                }
                $loader = $this->widgetsLoader;
                break;

            case "helpers":
                if($this->helpersLoader == null)
                {
                    $this->helpersLoader = new HelpersLoader();
                }
                $loader = $this->helpersLoader;
                break;
        }
        
        return $loader;
    }

    public static function render($template, $templateData, $view = null)
    {
        $templateFile = '';
        $path = TemplateEngine::getPath();
        $extension = explode('.', $template);
        $breakDown = explode('_', array_shift($extension));
        $extension = implode(".", $extension);
        for($i = 0; $i < count($breakDown); $i++)
        {
            $testTemplate = implode("_", array_slice($breakDown, $i, count($breakDown) - $i)) . ".$extension";
            foreach(TemplateEngine::getPath() as $path)
            {
                $newTemplateFile = "$path/$testTemplate";
                if(file_exists($newTemplateFile))
                {
                    $templateFile = $newTemplateFile;
                    break;
                }
            }
            if($templateFile != '') break;
        }
        
        if($templateFile == null)
        {
            $pathString = "[" . implode('; ', TemplateEngine::getPath()) . "]";
            throw new \ntentan\honam\exceptions\FileNotFoundException(
                "Could not find a suitable template file for the current request {$template}. Template path $pathString"
            );
        }
        else
        {
            return TemplateEngine::getEngineInstance($templateFile)->generate($templateData, $view);
        }
    }
    
    public static function reset()
    {
        self::$path = array();
    }
    
    public static function setAssetsBaseDir($assetsBase)
    {
        self::$assetsBase = $assetsBase;
    }
    
    public static function setPublicBaseDir($publicBase)
    {
        self::$publicBase = $publicBase;
    }

    abstract protected function generate($data);
}
