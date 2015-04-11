<?php
use ntentan\honam\template_engines\TemplateEngine;

function load_asset($asset, $copyFrom = null)
{
    return TemplateEngine::loadAsset($asset, $copyFrom);
}
