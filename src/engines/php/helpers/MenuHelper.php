<?php

namespace ntentan\honam\engines\php\helpers;

use ntentan\honam\engines\php\Helper;
use ntentan\honam\TemplateRenderer;

/**
 * A helper class for generating HTML menus.
 */
class MenuHelper extends Helper
{
    /**
     * All items in the menu.
     * @var array
     */
    private $items = array();
    private $cssClasses = [
        'menu' => [],
        'item' => [],
        'selected' => [],
        'matched' => []
    ];
    private $currentUrl;
    private $alias;
    private $hasLinks = true;

    const MENU = 'menu';
    const ITEM = 'item';
    const SELECTED_ITEM = 'selected';
    const MATCHED_ITEM = 'matched';

    public function __construct(TemplateRenderer $templateRenderer)
    {
        parent::__construct($templateRenderer);
        $this->setCurrentUrl(filter_var($_SERVER["REQUEST_URI"], FILTER_SANITIZE_URL));
    }

    public function help($items = null)
    {
        $this->items = $items;
        return $this;
    }

    public function addCssClass($class, $section = self::MENU)
    {
        $this->cssClasses[$section][] = $class;
        return $this;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function setCurrentUrl($currentUrl)
    {
        $this->currentUrl = $currentUrl;
        return $this;
    }

    public function setHasLinks($hasLinks)
    {
        $this->hasLinks = $hasLinks;
        return $this;
    }

    public function __toString()
    {
        $menuItems = array();

        foreach ($this->items as $index => $item) {
            if (is_string($item) || is_numeric($item)) {
                $item = [
                    'label' => $item,
                    'url' => is_string($index) ? $index : $this->makeFullUrl(strtolower(str_replace(' ', '_', $item))),
                    'default' => null
                ];
            }

            $item['selected'] = $item['url'] == substr($this->currentUrl, 0, strlen($item['url']));
            $item['fully_matched'] = $item['url'] == $this->currentUrl;
            $menuItems[$index] = $item;
        }

        return $this->templateRenderer->render(
            "{$this->alias}_menu.tpl.php",
            [
                'items' => $menuItems,
                'css_classes' => $this->cssClasses,
                'has_links' => $this->hasLinks,
                'alias' => $this->alias
            ]
        );
    }
}
