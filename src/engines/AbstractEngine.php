<?php

namespace ntentan\honam\engines;

abstract class AbstractEngine
{
    /**
     * Passes the data to be rendered to the template engine instance.
     * @param string $filePath
     * @param array $data
     * @return string
     */
    abstract public function renderFromFileTemplate(string $filePath, array $data) : string;

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     * @param string $string
     * @param array $data
     * @return string
     */
    abstract public function renderFromStringTemplate(string $string, array $data) : string;
    
}