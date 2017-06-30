<?php
use ntentan\honam\TemplateEngine;

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
