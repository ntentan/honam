<?php


namespace ntentan\honam\engines\php\helpers\form;

class Textarea extends Field
{
    public function render()
    {
        $this->setAttribute('rows', 10);
        $this->setAttribute('cols', 80);
        $this->setAttribute('name', $this->getName());
        return $this->templateRenderer->render("textarea_element.tpl.php", ['element' => $this]);
    }
}
