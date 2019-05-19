<?php

namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\mustache\MustacheLoader;
use ntentan\honam\engines\mustache\MustachePartialsLoader;
use ntentan\honam\engines\MustacheEngine;


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
