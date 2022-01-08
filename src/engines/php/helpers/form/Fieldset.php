<?php
namespace ntentan\honam\engines\php\helpers\form;

class Fieldset extends Container
{
    public function __construct($label="",$description="")
    {
        parent::__construct();
        $this->setLabel($label);
        $this->setDescription($description);
    }

    public function renderHead()
    {
        return $this->templateRenderer->render('fieldset_head.tpl.php', ['element' => $this]);
    }

    public function renderFoot()
    {
        return $this->templateRenderer->render('fieldset_foot.tpl.php',['element' => $this]);
    }
}

