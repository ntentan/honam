<?php

namespace ntentan\honam\helpers\lists;

use ntentan\Ntentan;
use ntentan\honam\template_engines\TemplateEngine;
use ntentan\honam\helpers\Helper;

class ListsHelper extends Helper
{
    public $headers = array();
    public $hasHeaders = true;
    public $data = array();
    public $rowTemplate = null;
    public $defaultCellTemplate = null;
    public $cellTemplates = array();
    public $variables = array();

    public function __toString()
    {
        TemplateEngine::appendPath(__DIR__ . '/templates');
        $this->rowTemplate = $this->rowTemplate == null ? 'row.tpl.php' : $this->rowTemplate;
        $this->defaultCellTemplate = $this->defaultCellTemplate == null ? 'default_cell.tpl.php' : $this->defaultCellTemplate;
        return TemplateEngine::render(
            'list.tpl.php',
            array(
                "headers"               =>  $this->headers,
                "data"                  =>  $this->data,
                "row_template"          =>  $this->rowTemplate,
                "cell_templates"        =>  $this->cellTemplates,
                "default_cell_template" =>  $this->defaultCellTemplate,
                "variables"             =>  $this->variables,
                "has_headers"           =>  $this->hasHeaders
            )
        );
    }
}

