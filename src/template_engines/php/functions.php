<?php
use ntentan\honam\AssetsLoader;
use ntentan\honam\TemplateEngine;

function load_asset($asset, $copyFrom = null)
{
    return AssetsLoader::load($asset, $copyFrom);
}

function t($template, $templateData = array())
{
    return TemplateEngine::render($template, $templateData);
}
