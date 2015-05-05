<?php
namespace ntentan\honam\helpers;

use ntentan\honam\helpers\MinifiablesHelper;

class StylesheetsHelper extends MinifiablesHelper
{
    protected function getExtension()
    {
        return "css";
    }

    protected function getMinifier()
    {
        return "css.css_minify";
    }

    protected function getTag($url)
    {
        return "<link type='text/css' rel='stylesheet' href='$url' />";
    }
}
