<?php
/* 
 * View Templating System
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
 */

namespace ntentan\views;

/**
 * The TemplateEngine class does the work of resolving templates, loading template files,
 * loading template engines and rendering templates. The `ntentan/views` package takes a reference to a 
 * template and tries to find a specific template file to be used for the rendering. 
 * `ntentan/views` does not expect to find all view templates in a single directory.
 * It uses a heirachy of directories which it searches for the template to render.
 * Templates in directories closer to the beginning of the array have a higher
 * priority over those closer to the end of the array.
 * 
 */
abstract class TemplateEngine
{
    /**
     * An array of loaded template engine instances.
     * @var array<\ntentan\views\TemplateEngine>
     */
    private static $loadedInstances;
    
    /**
     * The template file reference.
     * @var string
     */
    protected $template;
    
    /**
     * An instance of the helpers loader used for loading the helpers.
     * @var \ntentan\views\template_engines\HelpersLoader
     */
    private $helpersLoader;
    
    /**
     * The array which holds the template path heirachy.
     * 
     * @var array<string>
     */
    private static $path = array();

    /**
     * Append a directory to the end of the template path heirachy.
     * 
     * @param string $path
     */
    public static function appendPath($path)
    {
        self::$path[] = $path;
    }

    /**
     * Prepend a directory to the beginning of the template path heirachy.
     * 
     * @param string $path
     */
    public static function prependPath($path)
    {
        array_unshift(self::$path, $path);
    }

    /**
     * Return the template hierachy as an array.
     * 
     * @return array<string>
     */
    public static function getPath()
    {
        return self::$path;
    }

    /**
     * Loads a template engine instance to be used for rendering a given
     * template file. It determines the engine to be loaded by using the filename.
     * The extension of the file determines the engine to be loaded.
     * 
     * @param string $template The template file
     * @return \ntentan\views\TemplateEngine
     * @throws \ntentan\views\exceptions\TemplateEngineNotFoundException
     */
    private static function getEngineInstance($template)
    {
    	$last = explode(".", $template);
        $engine = end($last);
        if(!isset(TemplateEngine::$loadedInstances[$engine]))
        {
            $engineClass = "ntentan\\views\\template_engines\\" . \ntentan\utils\Text::ucamelize($engine);
            if(class_exists($engineClass))
            {
                $engineInstance = new $engineClass();
            }
            else
            {
                throw new \ntentan\views\exceptions\TemplateEngineNotFoundException("Could not load template engine class [$engineClass] for $template");
            }
            TemplateEngine::$loadedInstances[$engine] = $engineInstance;
        }
        TemplateEngine::$loadedInstances[$engine]->template = $template;
        return TemplateEngine::$loadedInstances[$engine];
    }

    /**
     * Returns the single instance of the helpers loader that is currently
     * stored in this class.
     * 
     * @return \ntentan\views\template_engines\HelpersLoader
     */
    public function getHelpersLoader()
    {
        if($this->helpersLoader == null)
        {
            $this->helpersLoader = new HelpersLoader();
        }
        return $this->helpersLoader;
    }
    
    /**
     * Resolve a template file by running through all the directories in the
     * template heirachy till a file that matches the template is found.
     * 
     * @param string $template
     * @return string
     * @throws \ntentan\views\exceptions\FileNotFoundException
     */
    protected static function resolveTemplateFile($template)
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
            throw new \ntentan\views\exceptions\FileNotFoundException(
                "Could not find a suitable template file for the current request {$template}. Template path $pathString"
            );
        }
        
        return $templateFile;
    }    

    /**
     * Renders a given template file with associated template data. This render
     * function combs through the template directory heirachy to find a template
     * file which matches the given template reference and uses it for the purpose
     * of rendering the view.
     * 
     * @param string $template The template reference file.
     * @param array $templateData The data to be passed to the template.
     * @return string
     * @throws \ntentan\views\exceptions\FileNotFoundException
     */
    public static function render($template, $templateData)
    {
        return TemplateEngine::getEngineInstance(self::resolveTemplateFile($template))->generate($templateData);
    }
    
    /**
     * Resets the path heirachy.
     */
    public static function reset()
    {
        self::$path = array();
    }

    /**
     * Passes the data to be rendered to the template engine instance.
     */
    abstract protected function generate($data);
}
