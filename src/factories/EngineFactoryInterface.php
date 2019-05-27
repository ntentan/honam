<?php

namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;
use ntentan\honam\TemplateRenderer;

/**
 * Interface TemplateEngineFactoryInterface
 *
 * @package ntentan\honam\template_engine_factories
 */
interface EngineFactoryInterface
{
    public function create() : AbstractEngine;
}
