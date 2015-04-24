<?php
namespace ntentan\views\helpers;

use ntentan\views\helpers\MinifiablesHelper;

class StylesheetsHelper extends MinifiablesHelper
{
    protected function getExtension()
    {
        return "css";
    }

    protected function getMinifier()
    {
        return "css.cssmin";
    }

    protected function getTag($url)
    {
        return "<link type='text/css' rel='stylesheet' href='$url' />";
    }
}
