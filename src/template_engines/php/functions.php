<?php
use ntentan\views\template_engines\AssetsLoader;
use ntentan\views\template_engines\TemplateEngine;

function load_asset($asset, $copyFrom = null)
{
    return AssetsLoader::load($asset, $copyFrom);
}

function t($template, $templateData = array())
{
    return TemplateEngine::render($template, $templateData);
}
