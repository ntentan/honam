<?php

namespace ntentan\honam\template_engines;

use ntentan\honam\TemplateEngine;

/**
 * Description of Mustache
 *
 * @author ekow
 */
class Mustache extends TemplateEngine
{
    private $loaderMustache;

    private $stringMustache;

    /**
     *
     * @return \Mustache_Engine
     */
    private function getMustache($loaders = true)
    {
        if ($loaders == true) {
            if(!$this->loaderMustache) {
                $this->loaderMustache = new \Mustache_Engine([
                    'loader' => new mustache\MustacheLoader(),
                    'partials_loader' => new mustache\MustachePartialsLoader($this)
                ]);
            }
            return $this->loaderMustache;
        } else {
            if(!$this->stringMustache) {
                $this->stringMustache = new \Mustache_Engine();
            }
            return $this->stringMustache;
        }
    }

    protected function generate($data)
    {
        $m = $this->getMustache();
        return $m->render($this->template, $data);
    }

    public function getTemplateFile($name)
    {
        return self::resolveTemplateFile($name);
    }

    protected function generateFromString($string, $data)
    {
        $m = $this->getMustache(false);
        return $m->render($string, $data);
    }

}
