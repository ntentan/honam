<?php

namespace ntentan\honam;

use ntentan\honam\exceptions\TemplateResolutionException;
use ntentan\utils\Filesystem;

class TemplateFileResolver
{
    /**
     * The array which holds the template path heirachy.
     *
     * @var array<string>
     */
    private $pathHierarchy = array();

    public function getPathHierarchy() : array
    {
        return $this->pathHierarchy;
    }

    public function setPathHierarchy(array $pathHierarchy) : void
    {
        $this->pathHierarchy = $pathHierarchy;
    }

    /**
     * Append a directory to the end of the template path heirachy.
     *
     * @param string $path
     */
    public function appendToPathHierarchy($path)
    {
        $this->pathHierarchy[] = $path;
    }

    /**
     * Prepend a directory to the beginning of the template path heirachy.
     *
     * @param string $path
     */
    public function prependToPathHierarchy($path)
    {
        array_unshift($this->pathHierarchy, $path);
    }

    private function testTemplateFile($testTemplate, $paths, $extension)
    {
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

    private function testNoEngineTemplateFile($testTemplate, $paths)
    {
        $templateFile = '';
        foreach ($paths as $path) {
            $newTemplateFile = "$testTemplate.*";
            if (!file_exists($path)) {
                continue;
            }
            $files = array_filter(
                iterator_to_array(Filesystem::directory($path)->getFiles(false)),
                function($file) use($newTemplateFile) {
                    return fnmatch($newTemplateFile, basename($file));
                });
            $files = array_map(function($file) { return basename($file);}, $files);
            if (count($files) == 1) {
                $templateFile = $path . "/" . reset($files);
                break;
            } else if (count($files) > 1) {
                $templates = implode(", ", $files);
                throw new TemplateResolutionException("Multiple templates were resolved for the request '$testTemplate'. Please ensure that only one supported template type of the name '$testTemplate' exists in the path '$path'. Files found: $templates");
            }
        }
        return $templateFile;
    }

    private function searchTemplateDirectory($template, $ignoreEngine = false)
    {
        $templateFile = '';
        $extension = '';

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

        $parts = count($breakDown);

        for ($i = 0; $i < $parts; $i++) {
            $testTemplate = implode("_", array_slice($breakDown, $i, count($breakDown) - $i));

            if ($ignoreEngine) {
                $templateFile = $this->testNoEngineTemplateFile($testTemplate, $this->pathHierarchy);
            } else {
                $templateFile = $this->testTemplateFile($testTemplate, $this->pathHierarchy, $extension);
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
     * @throws TemplateResolutionException
     */
    public function resolveTemplateFile($template)
    {
        if ($template == '') {
            throw new TemplateResolutionException("Empty template file requested");
        }

        if(file_exists($template)) {
            return $template;
        }

        $templateFile = $this->searchTemplateDirectory($template, pathinfo($template, PATHINFO_EXTENSION) === '');

        if ($templateFile == null) {
            $pathString = "[" . implode('; ', $this->pathHierarchy) . "]";
            throw new TemplateResolutionException(
                "Could not find a suitable template file for the current request '{$template}'. Current template path $pathString"
            );
        }

        return $templateFile;
    }
}
