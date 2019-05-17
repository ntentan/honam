<?php

namespace ntentan\honam\factories;

use ntentan\honam\template_engines\AbstractEngine;
use ntentan\honam\template_engines\mustache\MustacheLoader;
use ntentan\honam\template_engines\mustache\MustachePartialsLoader;
use ntentan\honam\template_engines\MustacheEngine;


class MustacheEngineFactory implements EngineFactoryInterface
{
    public function create() : AbstractEngine
    {
        $loaderMustache = new \Mustache_Engine([
            'loader' => new MustacheLoader(), 'partials_loader' => new MustachePartialsLoader()]
        );
        $stringMustache = new \Mustache_Engine(['partials_loader' => new MustachePartialsLoader()]);
        return new MustacheEngine($loaderMustache, $stringMustache);
    }
}
