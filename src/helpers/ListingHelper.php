<?php

namespace ntentan\honam\helpers;

use ntentan\honam\Helper;


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
    
    public function stylesheet()
    {
        return __DIR__ . '/../../assets/css/lists/lists.css';
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
     * @return ListingHelper
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
        return $this->templateRenderer->render('list.tpl.php', $this->parameters);
    }
}

