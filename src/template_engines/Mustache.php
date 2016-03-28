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
    private $mustache;
    /**
     * 
     * @return \Mustache_Engine
     */
    private function getMustache($loaders = true)
    {
        if(!is_object($this->mustache) && $loaders == true)
        {
            $this->mustache = new \Mustache_Engine([
                'loader' => new mustache\MustacheLoader(),
                'partials_loader' => new mustache\MustachePartialsLoader($this)
            ]);
        } elseif (!is_object($this->mustache)) {
            $this->mustache = new \Mustache_Engine();
        }
        return $this->mustache;
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
