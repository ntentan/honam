<?php
use ntentan\honam\template_engines\AssetsLoader;

function load_asset($asset, $copyFrom = null)
{
    return AssetsLoader::load($asset, $copyFrom);
}
