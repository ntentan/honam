<?php

namespace ntentan\views\template_engines\mustache;

use ntentan\views\TemplateEngine;

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
                'loader' => new MustacheLoader(),
                'partials_loader' => new MustachePartialsLoader($this)
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
