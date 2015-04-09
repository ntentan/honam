<?php
namespace ntentan\honam\helpers\minifiables\minifiers\js\jshrink;
use ntentan\honam\helpers\minifiables\Minifier;

class JshrinkMinifier extends Minifier
{
    public function performMinification($script)
    {
        $minified = \JShrink\Minifier::minify(
            $script, array('flaggedComments' => false)
        );
        return $minified;
    }
}
