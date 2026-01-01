<?php

namespace ntentan\honam\engines\php\helpers;

use ntentan\honam\engines\php\Helper;
use ntentan\honam\engines\php\Variable;
use ntentan\honam\TemplateRenderer;

/**
 * A helper class for rendering HTML menus.
 * This class takes an an associated array of paths, labels, and other properties to generate a navigation tree. The
 * tree takes into consideration the current path being rendered (as passed to the helper variable either through
 * a framework or passed manually) and highlights it with special classes.
 */
class MenuHelper extends Helper
{
    /**
     * The menu structure to be rendered.
     * @var array
     */
    private array $items;

    /**
     * Custom CSS classes to apply to the different menu items.
     * @var array[]
     */
    private array $cssClasses = [
        'menu' => [],
        'item' => [],
        'selected' => [],
        'matched' => []
    ];

    /**
     * An prefix to apply to the menu template.
     * @var
     */
    private string $alias = '';

    /**
     * Set that the menu items have links.
     * @var bool
     */
    private $hasLinks = true;

    const MENU = 'menu';
    const ITEM = 'item';
    const SELECTED_ITEM = 'selected';
    const MATCHED_ITEM = 'matched';

    public function __construct(TemplateRenderer $templateRenderer)
    {
        parent::__construct($templateRenderer);
        $templateRenderer->getTemplateFileResolver()->appendToPathHierarchy(__DIR__ . "/../../../templates/menus");
    }

    public function help(mixed $items): Helper
    {
        $this->items = $items instanceof Variable ? $items->u() : $items;
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
                    'url' => is_string($index) ? $index : strtolower(str_replace(' ', '_', $item)),
                    'default' => null
                ];
            }

            $item['selected'] = $item['url'] == substr($this->getBaseUrl(), 0, strlen($item['url']));
            $item['fully_matched'] = $item['url'] == $this->getBaseUrl();
            $menuItems[$index] = $item;
        }

        return $this->templateRenderer->render(
            "{$this->alias}_menu.tpl.php", [
                'prefix' => $this->getPrefix(),
                'items' => $menuItems,
                'css_classes' => $this->cssClasses,
                'has_links' => $this->hasLinks,
                'alias' => $this->alias
            ]
        );
    }
}
