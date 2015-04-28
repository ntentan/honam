<?php

namespace ntentan\honam\template_engines;

use ntentan\honam\TemplateEngine;

/**
 * Description of Mustache
 *
 * @author ekow
 */
class Smarty extends TemplateEngine
{
    private $smarty;
    
    private function getSmarty()
    {
        if($this->smarty === null)
        {
            $this->smarty = new smarty\Engine();
        }
        return $this->smarty;
    }
    
    protected function generate($data) 
    {
        $smarty = $this->getSmarty();
        $smarty->clearAllAssign();
        $data['honam'] = $this->getHelpersLoader();
        $smarty->assign($data);
        return $smarty->fetch($this->template);
    }
}
