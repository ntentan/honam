<?php
use ntentan\honam\AssetsLoader;
use ntentan\honam\TemplateEngine;

function load_asset($asset, $copyFrom = null)
{
    return AssetsLoader::load($asset, $copyFrom);
}

function get_asset($asset)
{
    return AssetsLoader::getAssetPath($asset);
}

function t($template, $templateData = array())
{
    return TemplateEngine::render($template, $templateData);
}

function unescape($item)
{
    if($item instanceof ntentan\honam\template_engines\php\Variable) {
        return $item->unescape();
    } else {
        return $item;
    }
}
