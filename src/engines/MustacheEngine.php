<?php

namespace ntentan\honam\engines;

/**
 * Description of Mustache
 *
 * @author ekow
 */
class MustacheEngine extends AbstractEngine
{
    private $stringRenderingEngine;
    private $fileRenderingEngine;

    /**
     *
     * @return \Mustache_Engine
     */
    public function __construct($stringRenderingEngine, $fileRenderingEngine)
    {
        $this->stringRenderingEngine = $stringRenderingEngine;
        $this->fileRenderingEngine = $fileRenderingEngine;
    }

    protected function generate($data)
    {
        $m = $this->getMustache();
        return $m->render($this->template, $data);
    }

    public function getTemplateFile($name)
    {
        return $this->resolveTemplateFile($name);
    }

    protected function generateFromString($string, $data)
    {
        $m = $this->getMustache(false);
        return $m->render($string, $data);
    }

}
