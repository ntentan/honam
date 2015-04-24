<?php

namespace ntentan\honam\template_engines\mustache;

/**
 * Description of MustacheLoader
 *
 * @author ekow
 */
class MustacheLoader implements \Mustache_Loader
{
    public function load($name) 
    {
        return file_get_contents($name);
    }
}
