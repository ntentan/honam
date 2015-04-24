<?php
namespace ntentan\honam\helpers\minifiables;

abstract class Minifier
{
    public abstract function performMinification($script);

    public static function minify($script, $minifier)
    {
        return self::getMinifier($minifier)->performMinification($script);
    }

    private static function getMinifier($minifier)
    {
        $array = explode('.', $minifier);
        $minifierName = end($array);
        $class = __NAMESPACE__ . "\\minifiers\\" . reset($array) . '\\' . \ntentan\utils\Text::ucamelize($minifierName) . "Minifier";
        $instance = new $class();
        return $instance;
    }
}
