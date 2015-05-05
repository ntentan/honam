<?php
namespace ntentan\honam\helpers\minifiables\minifiers\css;
use ntentan\honam\helpers\minifiables\Minifier;
use MatthiasMullie\Minify\CSS;

class CssMinifyMinifier extends Minifier
{
    public function performMinification($script)
    {
        $minifier = new CSS();
        $minifier->add($script);
        return $minifier->minify();
    }
}
