<?php
namespace ntentan\honam\engines\php\helpers;

use ntentan\honam\engines\php\Helper;
use ntentan\utils\Input;

class PaginationHelper extends Helper
{
    private array $parameters = [
        'query' => null,
        'number_of_links' => 21,
        'number_of_items' => null,
        'items_per_page' => 10,
        'base_url' => null,
        'page_number' => 1
    ];

    private $halfNumberOfLinks;

    public function __construct(\ntentan\honam\TemplateRenderer $templateRenderer)
    {
        parent::__construct($templateRenderer);
        $templateRenderer->getTemplateFileResolver()->appendToPathHierarchy(__DIR__ . "/../../../../templates/pagination");
    }

    public function help(mixed $params): Helper
    {
        $this->parameters = array_merge($this->parameters, $params);
        $this->parameters['number_of_pages'] = ceil($this->parameters['number_of_items'] / $this->parameters['items_per_page']);
        $this->halfNumberOfLinks = ceil($this->parameters['number_of_links'] / 2);
        if ($this->parameters['query'] != '') {
            $this->parameters['page_number'] = Input::get($this->parameters['query']) == '' ? 1 : Input::get($this->parameters['query']);
        }
        return $this;
    }


    private function getLink($index)
    {
        if ($this->parameters['query'] == '') {
            $link = $this->parameters['base_url'] . $index;
        } else {
            $link = $this->parameters['base_url'] . '?';
            $get = Input::get();
            foreach ($get as $key => $value) {
                if ($key == $this->parameters['query']) continue;
                $link .= "$key=" . urlencode($value) . '&';
            }
            $link .= "{$this->parameters['query']}=$index";
        }
        return $link;
    }

    public function __toString()
    {
        $pagingLinks = array();
        if ($this->parameters['page_number'] > 1) {
            $pagingLinks[] = array(
                "link" => $this->getLink($this->parameters['page_number'] - 1),
                "label" => "Prev",
                "selected" => false
            );
        }

        if ($this->parameters['number_of_pages'] <= $this->parameters['number_of_links'] || $this->parameters['page_number'] < $this->halfNumberOfLinks) {
            for ($i = 1; $i <= ($this->parameters['number_of_pages'] > $this->parameters['number_of_links'] ? $this->parameters['number_of_links'] : $this->parameters['number_of_pages']); $i++) {

                $pagingLinks[] = array(
                    "link" => $this->getLink($i),
                    "label" => "$i",
                    "selected" => $this->parameters['page_number'] == $i
                );
            }
        } else {
            if ($this->parameters['number_of_pages'] - $this->parameters['page_number'] < $this->halfNumberOfLinks) {
                $startOffset = $this->parameters['page_number'] - (($this->parameters['number_of_links'] - 1) - ($this->parameters['number_of_pages'] - $this->parameters['page_number']));
                $endOffset = $this->parameters['page_number'] + ($this->parameters['number_of_pages'] - $this->parameters['page_number']);
            } else {
                $startOffset = $this->parameters['page_number'] - ($this->halfNumberOfLinks - 1);
                $endOffset = $this->parameters['page_number'] + ($this->halfNumberOfLinks - 1);
            }
            for ($i = $startOffset; $i <= $endOffset; $i++) {
                $pagingLinks[] = array(
                    "link" => $this->getLink($i),
                    "label" => "$i",
                    "selected" => $this->parameters['page_number'] == $i
                );
            }
        }

        if ($this->parameters['page_number'] < $this->parameters['number_of_pages']) {
            $pagingLinks[] = array(
                "link" => $this->getLink($this->parameters['page_number'] + 1),
                "label" => "Next",
                "selected" => false
            );
        }

        return $this->templateRenderer->render("links.tpl.php", array('links' => $pagingLinks));
    }
}
