<?php

namespace ntentan\honam\engines;

use ntentan\honam\TemplateEngine;

/**
 * Description of Mustache
 *
 * @author ekow
 */
class Smarty extends TemplateEngine
{
    private $smarty;
    
    private function getSmarty($data)
    {
        if($this->smarty === null)
        {
            $this->smarty = new smarty\Engine();
        }
        $this->smarty->clearAllAssign();
        $this->smarty->assign($data);
        return $this->smarty;
    }
    
    protected function generate($data) 
    {
        return $this->getSmarty($data)->fetch($this->template);
    }

    protected function generateFromString($string, $data)
    {
        return $this->getSmarty($data)->display("string:$string");
    }

}
