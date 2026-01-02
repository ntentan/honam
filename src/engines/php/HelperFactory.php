<?php

namespace ntentan\honam\engines\php;

use ntentan\honam\engines\php\helpers\DateHelper;
use ntentan\honam\engines\php\helpers\FeedHelper;
use ntentan\honam\engines\php\helpers\FilesizeHelper;
use ntentan\honam\engines\php\helpers\FormHelper;
use ntentan\honam\engines\php\helpers\ListingHelper;
use ntentan\honam\engines\php\helpers\MenuHelper;
use ntentan\honam\engines\php\helpers\PaginationHelper;
use ntentan\honam\exceptions\HelperException;
use ntentan\honam\TemplateRenderer;

class HelperFactory
{
    private array $factories = [
        'form' => FormHelper::class,
        'listing' => ListingHelper::class,
        'menu' => MenuHelper::class,
        'pagination' => PaginationHelper::class,
        'date' => DateHelper::class,
        'feed' => FeedHelper::class,
        'filesize' => FilesizeHelper::class
    ];

    public function __construct(private string $baseUrl = '/', private string $prefix = '')
    {
    }

    /**
     * Get the instance of a helper given the string name of the helper.
     *
     * @param string $helperName
     * @param TemplateRenderer $templateRenderer
     * @return Helper
     * @throws HelperException
     */
    public function create (string $helperName, TemplateRenderer $templateRenderer) : Helper
    {
        if (!isset($this->factories[$helperName]) || !class_exists($this->factories[$helperName]) ) {
            throw new HelperException("The helper '$helperName' is not defined.");
        }
        $helperClass = $this->factories[$helperName];
        $helperInstance = new $helperClass($templateRenderer);
        $helperInstance->setUrlParameters($this->baseUrl, $this->prefix);
        return $helperInstance;
    }

    public function registerHelper(string $helperName, string $helperClass): void
    {
        $this->factories[$helperName] = $helperClass;
    }
}