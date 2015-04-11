<?php
namespace ntentan\honam\template_engines;

abstract class TemplateEngine
{
    private static $loadedInstances;
    protected $template;
    private $widgetsLoader;
    private $helpersLoader;
    private static $path = array();

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
    
    public static function loadAssetWithUrl($asset, $copyFrom = null)
    {
        return Ntentan::getUrl(self::loadAsset($asset, $copyFrom));
    }

    public static function loadAsset($asset, $copyFrom = null)
    {
        $assetPath = ($copyFrom==null ? "assets/$asset" : $copyFrom);
        $publicPath = "public/$asset";
        $publicDirectory = dirname($publicPath);
        
        if(file_exists($publicPath) && !Ntentan::$debug) return $publicPath;
        
        if(file_exists($assetPath) && file_exists($publicDirectory) && is_writable($publicDirectory))
        {
            copy($assetPath, $publicPath);
        }
        else if(file_exists(Ntentan::getFilePath("assets/$asset")) && file_exists($publicDirectory) && is_writable($publicDirectory))
        {
            copy(Ntentan::getFilePath("assets/$asset"), $publicPath);
        }
        else if(file_exists($copyFrom) && is_writable($publicDirectory))
        {
            copy($copyFrom, $publicPath);
        }
        else
        {
            if(!file_exists($assetPath))
            {
                Ntentan::error("File not found <b><code>$assetPath</code></b>");
            }
            else if(!is_writable($publicPath))
            {
                Ntentan::error("Destination <b><code>public/$asset</code></b> is not writable");
            }
            die();
        }
        return $publicPath;
    }

    public function __get($property)
    {
        switch($property)
        {
            case "widgets":
                if($this->widgetsLoader == null)
                {
                    $this->widgetsLoader = new WidgetsLoader();
                }
                return $this->widgetsLoader;


            case "helpers":
                if($this->helpersLoader == null)
                {
                    $this->helpersLoader = new HelpersLoader();
                }
                return $this->helpersLoader;
        }
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
            throw new \ntentan\honam\exceptions\TemplateFileNotFoundException(
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

    abstract protected function generate($data);
}
