<?php

namespace ntentan\honam\engines;

use Mustache_Engine;

/**
 * Description of Mustache
 *
 * @author ekow
 */
class MustacheEngine extends AbstractEngine
{
    private $stringRenderingEngine;
    private $fileRenderingEngine;

    public function __construct(Mustache_Engine $stringRenderingEngine, Mustache_Engine $fileRenderingEngine)
    {
        $this->stringRenderingEngine = $stringRenderingEngine;
        $this->fileRenderingEngine = $fileRenderingEngine;
    }

    /**
     * Passes the data to be rendered to the template engine instance.
     * @param string $filePath
     * @param array $data
     * @return string
     */
    public function renderFromFileTemplate(string $filePath, array $data): string
    {
        return $this->fileRenderingEngine->render($filePath, $data);
    }

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     * @param string $string
     * @param array $data
     * @return string
     */
    public function renderFromStringTemplate(string $string, array $data): string
    {
        return $this->stringRenderingEngine->render($string, $data);
    }
}
