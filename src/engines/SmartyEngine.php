<?php

namespace ntentan\honam\engines;


use ntentan\honam\template_engines\smarty\Engine;

/**
 * Description of Mustache
 *
 * @author ekow
 */
class SmartyEngine extends AbstractEngine
{
    private $smarty;

    public function __construct(Engine $smarty)
    {

    }

    private function getSmarty($data)
    {
        if($this->smarty === null)
        {
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

    /**
     * Passes the data to be rendered to the template engine instance.
     * @param string $filePath
     * @param array $data
     * @return string
     */
    public function renderFromFileTemplate(string $filePath, array $data): string
    {
        // TODO: Implement renderFromFileTemplate() method.
    }

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     * @param string $string
     * @param array $data
     * @return string
     */
    public function renderFromStringTemplate(string $string, array $data): string
    {
        // TODO: Implement renderFromStringTemplate() method.
    }
}
