<?php
use ntentan\views\AssetsLoader;
use ntentan\views\TemplateEngine;

function load_asset($asset, $copyFrom = null)
{
    return AssetsLoader::load($asset, $copyFrom);
}

function t($template, $templateData = array())
{
    return TemplateEngine::render($template, $templateData);
}
