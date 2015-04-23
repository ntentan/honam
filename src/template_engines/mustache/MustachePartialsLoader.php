<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ntentan\views\template_engines\mustache;

/**
 * Description of MustachePartialsLoader
 *
 * @author ekow
 */
class MustachePartialsLoader implements \Mustache_Loader
{
    private $mustache;
    
    public function __construct($mustache) 
    {
        $this->mustache = $mustache;
    }
    
    public function load($name) 
    {
        return file_get_contents($this->mustache->getTemplateFile("$name.mustache"));
    }
}
