<?php

namespace ntentan\honam\engines;


use ntentan\honam\engines\smarty\Core;

/**
 * Description of Mustache
 *
 * @author ekow
 */
class SmartyEngine extends AbstractEngine
{
    private $smarty;

    public function __construct(Core $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * Passes the data to be rendered to the template engine instance.
     * @param string $filePath
     * @param array $data
     * @return string
     * @throws \SmartyException
     */
    public function renderFromFileTemplate(string $filePath, array $data): string
    {
        $this->smarty->setData($data);
        return $this->smarty->fetch($filePath);
    }

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     * @param string $string
     * @param array $data
     * @return string
     * @throws \SmartyException
     */
    public function renderFromStringTemplate(string $string, array $data): string
    {
        $this->smarty->setData($data);
        return $this->smarty->fetch("string:$string");
    }
}
