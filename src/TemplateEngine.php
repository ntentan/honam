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

namespace ntentan\honam;

use ntentan\honam\exceptions\TemplateResolutionException;

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
abstract class TemplateEngine {

    /**
     * An array of loaded template engine instances.
     * @var array<\ntentan\honam\TemplateEngine>
     */
    private static $loadedInstances;

    /**
     * The path to the template file to be used when generate is called. 
     * @var string
     */
    protected $template;

    /**
     * An instance of the helpers loader used for loading the helpers.
     * @var \ntentan\honam\template_engines\HelpersLoader
     */
    private $helpersLoader;

    /**
     * The array which holds the template path heirachy.
     * 
     * @var array<string>
     */
    private static $path = array();
    private static $tempDirectory = '.';

    /**
     * Append a directory to the end of the template path heirachy.
     * 
     * @param string $path
     */
    public static function appendPath($path) {
        self::$path[] = $path;
    }

    /**
     * Prepend a directory to the beginning of the template path heirachy.
     * 
     * @param string $path
     */
    public static function prependPath($path) {
        array_unshift(self::$path, $path);
    }

    /**
     * Return the template hierachy as an array.
     * 
     * @return array<string>
     */
    public static function getPath() {
        return self::$path;
    }

    private static function getEngineClass($engine) {
        return "ntentan\\honam\\template_engines\\" . \ntentan\utils\Text::ucamelize($engine);
    }

    private static function getEngineInstance($engine) {
        if (!isset(self::$loadedInstances[$engine])) {
            $engineClass = self::getEngineClass($engine);
            if (class_exists($engineClass)) {
                $engineInstance = new $engineClass();
            } else {
                throw new \ntentan\honam\exceptions\TemplateEngineNotFoundException("Could not load template engine class [$engineClass]");
            }
            self::$loadedInstances[$engine] = $engineInstance;
        }

        return self::$loadedInstances[$engine];
    }

    /**
     * Loads a template engine instance to be used for rendering a given
     * template file. It determines the engine to be loaded by using the filename.
     * The extension of the file determines the engine to be loaded.
     * 
     * @param string $template The template file
     * @return \ntentan\honam\TemplateEngine
     * @throws \ntentan\honam\exceptions\TemplateEngineNotFoundException
     */
    private static function getEngineInstanceWithTemplate($template) {
        $engine = pathinfo($template, PATHINFO_EXTENSION);
        $engineInstance = self::getEngineInstance($engine);
        $engineInstance->template = $template;
        return $engineInstance;
    }

    public static function canRender($file) {
        return class_exists(self::getEngineClass(pathinfo($file, PATHINFO_EXTENSION)));
    }

    /**
     * Returns the single instance of the helpers loader that is currently
     * stored in this class.
     * 
     * @return \ntentan\honam\template_engines\HelpersLoader
     */
    public function getHelpersLoader() {
        if ($this->helpersLoader == null) {
            $this->helpersLoader = new HelpersLoader();
        }
        return $this->helpersLoader;
    }

    private static function testTemplateFile($testTemplate, $paths, $extension) {
        $templateFile = '';
        foreach ($paths as $path) {
            $newTemplateFile = "$path/$testTemplate.$extension";
            if (file_exists($newTemplateFile)) {
                $templateFile = $newTemplateFile;
                break;
            }
        }
        return $templateFile;
    }

    private static function testNoEngineTemplateFile($testTemplate, $paths) {
        $templateFile = '';
        foreach ($paths as $path) {
            $newTemplateFile = "$path/$testTemplate.*";
            $files = glob($newTemplateFile);
            if (count($files) == 1) {
                $templateFile = $files[0];
                break;
            } else if (count($files) > 1) {
                $templates = implode(", ", $files);
                throw new TemplateResolutionException("Multiple templates ($templates) resolved for request");
            }
        }
        return $templateFile;
    }

    private static function searchTemplateDirectory($template, $ignoreEngine = false) {
        $templateFile = '';
        $paths = self::getPath();

        // Split the filename on the dots. The first part before the first dot
        // would be used to implement the file breakdown. The other parts are
        // fused together again and appended during the evaluation of the
        // breakdown.

        if ($ignoreEngine) {
            $breakDown = explode('_', $template);
        } else {
            $splitOnDots = explode('.', $template);
            $breakDown = explode('_', array_shift($splitOnDots));
            $extension = implode(".", $splitOnDots);
        }

        for ($i = 0; $i < count($breakDown); $i++) {
            $testTemplate = implode("_", array_slice($breakDown, $i, count($breakDown) - $i));

            if ($ignoreEngine) {
                $templateFile = self::testNoEngineTemplateFile($testTemplate, $paths);
            } else {
                $templateFile = self::testTemplateFile($testTemplate, $paths, $extension);
            }

            if ($templateFile != '') {
                break;
            }
        }

        return $templateFile;
    }

    /**
     * Resolve a template file by running through all the directories in the
     * template heirachy till a file that matches the template is found.
     * 
     * @param string $template
     * @return string
     * @throws \ntentan\honam\exceptions\FileNotFoundException
     */
    protected static function resolveTemplateFile($template) {
        if ($template == '') {
            throw new TemplateResolutionException("Empty template file requested");
        }

        $templateFile = self::searchTemplateDirectory($template, pathinfo($template, PATHINFO_EXTENSION) === '');

        if ($templateFile == null) {
            $pathString = "[" . implode('; ', self::getPath()) . "]";
            throw new TemplateResolutionException(
            "Could not find a suitable template file for the current request '{$template}'. Current template path $pathString"
            );
        }

        return $templateFile;
    }

    /**
     * Renders a given template reference with associated template data. This render
     * function combs through the template directory heirachy to find a template
     * file which matches the given template reference and uses it for the purpose
     * of rendering the view.
     * 
     * @param string $template The template reference file.
     * @param array $templateData The data to be passed to the template.
     * @return string
     * @throws \ntentan\honam\exceptions\FileNotFoundException
     */
    public static function render($template, $templateData) {
        return self::getEngineInstanceWithTemplate(self::resolveTemplateFile($template))->generate($templateData);
    }

    /**
     * Renders a given template file with the associated template data. This
     * render function loads the appropriate engine and passes the file to it
     * for rendering.
     * 
     * @param string $templatePath A path to the template file
     * @param string $templateData An array of the template data to be rendered
     * @return string
     */
    public static function renderFile($templatePath, $templateData) {
        return self::getEngineInstanceWithTemplate($templatePath)->generate($templateData);
    }

    public static function renderString($templateString, $engine, $templateData) {
        return self::getEngineInstance($engine)->generateFromString($templateString, $templateData);
    }

    /**
     * Resets the path heirachy.
     */
    public static function reset() {
        self::$path = array();
        self::$loadedInstances = array();
    }

    public static function getTempDirectory() {
        return self::$tempDirectory;
    }

    /**
     * Passes the data to be rendered to the template engine instance.
     */
    abstract protected function generate($data);

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     */
    abstract protected function generateFromString($string, $data);
}
