<?php

namespace ntentan\honam\factories;

use Mustache_Engine;
use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\engines\mustache\MustacheLoader;
use ntentan\honam\engines\mustache\MustachePartialsLoader;
use ntentan\honam\engines\MustacheEngine;
use ntentan\honam\TemplateFileResolver;


class MustacheEngineFactory implements EngineFactoryInterface
{
    private $templateFileResolver;

    public function __construct(TemplateFileResolver $templateFileResolver)
    {
        $this->templateFileResolver = $templateFileResolver;
    }

    public function create() : AbstractEngine
    {
        $loaderMustache = new Mustache_Engine([
            'loader' => new MustacheLoader(), 'partials_loader' => new MustachePartialsLoader($this->templateFileResolver)]
        );
        $stringMustache = new Mustache_Engine(['partials_loader' => new MustachePartialsLoader($this->templateFileResolver)]);
        return new MustacheEngine($loaderMustache, $stringMustache);
    }
}
