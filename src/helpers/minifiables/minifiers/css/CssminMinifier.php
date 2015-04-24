<?php
namespace ntentan\honam\helpers\minifiables\minifiers\css;
use ntentan\honam\helpers\minifiables\Minifier;

class CssminMinifier extends Minifier
{
    public function performMinification($script)
    {
        return \CssMin::minify($script);
    }
}
