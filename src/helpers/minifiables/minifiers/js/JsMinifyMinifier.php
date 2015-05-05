<?php
namespace ntentan\honam\helpers\minifiables\minifiers\js;
use ntentan\honam\helpers\minifiables\Minifier;
use MatthiasMullie\Minify\JS;

class JsMinifyMinifier extends Minifier
{
    public function performMinification($script)
    {
        $minifier = new JS();
        $minifier->add($script);
        return $minifier->minify();
    }
}
