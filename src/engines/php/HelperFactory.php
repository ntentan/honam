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
    private array $factories;

    public function __construct(private string $baseUrl = '/', private string $prefix = '')
    {
        $this->factories = [
            'form' => $this->makeFactory(FormHelper::class),
            'listing' => $this->makeFactory(ListingHelper::class),
            'menu' => $this->makeFactory(MenuHelper::class),
            'pagination' => $this->makeFactory(PaginationHelper::class),
            'date' => $this->makeFactory(DateHelper::class),
            'feed' => $this->makeFactory(FeedHelper::class),
            'filesize' => $this->makeFactory(FilesizeHelper::class)
        ];
    }

    private function makeFactory(string $helperClass): callable
    {
        return function (TemplateRenderer $templateRenderer) use ($helperClass) {
            return new $helperClass($templateRenderer);
        };
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
        if (!isset($this->factories[$helperName])) {
            throw new HelperException("The helper '$helperName' is not defined.");
        }
        $helperInstance = $this->factories[$helperName]($templateRenderer);
        $helperInstance->setUrlParameters($this->baseUrl, $this->prefix);
        return $helperInstance;
    }

    public function registerHelper(string $helperName, callable $callable): void
    {
        $this->factories[$helperName] = $callable;
    }
}