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
    
    private function getMustache()
    {
        if(!is_object($this->mustache))
        {
            $this->mustache = new \Mustache_Engine([
                'loader' => new mustache\MustacheLoader(),
                'partials_loader' => new mustache\MustachePartialsLoader($this)
            ]);
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
}
