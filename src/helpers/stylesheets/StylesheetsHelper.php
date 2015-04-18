<?php
namespace ntentan\honam\helpers\stylesheets;

use ntentan\honam\helpers\minifiables\MinifiablesHelper;

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
