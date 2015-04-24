<?php
/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ntentan\honam\helpers;

use ntentan\honam\helpers\MinifiablesHelper;

class JavascriptsHelper extends MinifiablesHelper
{
    protected function getExtension()
    {
        return "js";
    }

    protected function getMinifier()
    {
        return "js.jshrink";
    }

    protected function getTag($url)
    {
        return "<script type='text/javascript' src='$url' charset='utf-8'></script>";
    }
}
