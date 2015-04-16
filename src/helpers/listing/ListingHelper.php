<?php

namespace ntentan\honam\helpers\listing;

use ntentan\honam\template_engines\TemplateEngine;
use ntentan\honam\helpers\Helper;

class ListingHelper extends Helper
{
    private $parameters =        array(
          "headers"               =>  array(),
          "data"                  =>  array(),
          "row_template"          =>  null,
          "cell_templates"        =>  null,
          "default_cell_template" =>  null,
          "variables"             =>  null
       );
    
    public function __construct() {
        \ntentan\honam\template_engines\TemplateEngine::appendPath(
            __DIR__ . "/../../../templates/lists"
        );
    }
    
    /**
     *  array(
     *     "headers"               =>  $this->headers,
     *     "data"                  =>  $this->data,
     *     "row_template"          =>  $this->rowTemplate,
     *     "cell_templates"        =>  $this->cellTemplates,
     *     "default_cell_template" =>  $this->defaultCellTemplate,
     *     "variables"             =>  $this->variables,
     *  )
     * @param type $arguments
     */
    public function help($arguments)
    {
        $this->parameters = array_merge($this->parameters, $arguments);
        return $this;
    }

    public function __toString()
    {
        $this->parameters['row_template'] = $this->parameters['row_template'] == null ? 'row.tpl.php' : $this->parameters['row_template'];
        $this->parameters['default_cell_template'] = $this->parameters['default_cell_template'] == null ? 'default_cell.tpl.php' : $this->parameters['default_cell_template'];
        return TemplateEngine::render('list.tpl.php', $this->parameters);
    }
}

