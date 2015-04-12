<?php
/*
 * The view class for dealing with views
 * 
 * Honam Templating System
 * Copyright (c) 2008-2015 James Ekow Abaka Ainooson
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
 * 
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright Copyright 2010-2015 James Ekow Abaka Ainooson
 * @license MIT
 */

namespace ntentan\honam\template_engines;

/**
 * The TemplateEngine class does the work of resolving templates, loading templates,
 * loading template engines and rendering them. Honam takes a reference to a 
 * template and tries to find a specific template file to be used for the rendering. 
 * 
 */
abstract class TemplateEngine
{
    /**
     * 
     * @var type 
     */
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

    /**
     * 
     * @property widgets
     * @property helpers
     * @param type $property
     * @return type
     */
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

    abstract protected function generate($data);
}
