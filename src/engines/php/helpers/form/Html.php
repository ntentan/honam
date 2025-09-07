<?php
namespace ntentan\honam\engines\php\helpers\form;

class Html extends Element
{
    private $htmlCode;

    public function __construct(string $htmlCode)
    {
        parent::__construct("");
        $this->htmlCode = $htmlCode;
    }

    public function render(): string
    {
        return $this->htmlCode;
    }
}
