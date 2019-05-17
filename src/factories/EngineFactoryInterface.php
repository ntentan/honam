<?php

namespace ntentan\honam\factories;

use ntentan\honam\engines\AbstractEngine;

/**
 * Interface TemplateEngineFactoryInterface
 *
 * @package ntentan\honam\template_engine_factories
 */
interface EngineFactoryInterface
{
    public function create() : AbstractEngine;
}
