<?php
namespace ntentan\honam\template_engines\php;

/**
 * 
 */
class Janitor
{
    public static function cleanHtml($string, $strip = false)
    {
        if($strip === false)
        {
            return htmlspecialchars((string)$string);
        }
        else
        {
            return strip_tags((string)$string);
        }
    }
}