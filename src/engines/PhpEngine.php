<?php

/*
 * Ntentan Framework
 * Copyright (c) 2010-2015 James Ekow Abaka Ainooson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 */

namespace ntentan\honam\engines;

use Exception;
use ntentan\honam\engines\php\HelperVariable;
use ntentan\honam\engines\php\Janitor;
use ntentan\honam\engines\php\Variable;
use ntentan\honam\TemplateRenderer;
use ntentan\utils\StringStream;

/**
 * The PHP engine is a template engine built into honam which uses raw PHP as
 * the template language. By virtue of this, the PHP engine can boast of high
 * performance. Since this engine uses PHP, it has access to all the language's
 * features. This could sometimes create a problem since some of these features
 * are not intended for templating use.
 */
class PhpEngine extends AbstractEngine
{
    /**
     * @var HelperVariable
     */
    private $helperVariable;

    /**
     * @var Janitor
     */
    private $janitor;
    private $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer, HelperVariable $helperVariable, Janitor $janitor)
    {
        $this->helperVariable = $helperVariable;
        $this->janitor = $janitor;
        $this->templateRenderer = $templateRenderer;
    }

    public function partial($template, $templateData = array())
    {
        return $this->templateRenderer->render($template, $templateData);
    }

    /**
     * @param mixed $item
     * @return mixed
     */
    public function unescape($item)
    {
        if($item instanceof Variable) {
            return $item->unescape();
        } else {
            return $item;
        }
    }

    /**
     * Passes the data to be rendered to the template engine instance.
     */
    public function renderFromFileTemplate(string $filePath, array $data) : string
    {
        // Escape each variable by passing it through the variable class.
        // Users would have to unescape them by calling the escape method directly
        // on the variable.
        foreach ($data as $_key => $_value) {
            $$_key = Variable::initialize($_value, $this->janitor);
        }

        // Expose helpers
        $helpers = $this->helperVariable;

        // Start trapping the output buffer and include the PHP template for
        // execution.
        ob_start();
        try {
            include $filePath;
        } catch (Exception $e) {
            ob_get_flush();
            throw $e;
        }
        return ob_get_clean();
    }

    /**
     * Passes a template string and data to be rendered to the template engine
     * instance.
     */
    public function renderFromStringTemplate(string $string, array $data) : string
    {
        foreach ($data as $_key => $_value) {
            $$_key = Variable::initialize($_value, $this->janitor);
        }
        // Expose helpers
        $helpers = $this->helperVariable;
        
        ob_start();
        eval(" ?> $string");
        return ob_get_clean();
    }

    /**
     * A utility function to strip the text of all HTML code. This function
     * removes all HTML tags instead of escaping them.
     *
     * @param string $text
     * @return string
     */
    public function strip($text)
    {
        return $this->janitor->cleanHtml($text, true);
    }

    /**
     * A utility function to cut long pieces of text into meaningful short
     * chunks. The function is very good in cases where you want to show just
     * a short preview snippet of a long text. The function cuts the long string
     * without cutting through words and appends some sort of ellipsis
     * terminator to the text.
     *
     * @param string $text The text to be truncated.
     * @param integer $length The maximum lenght of the truncated string. Might
     *      return a shorter string if the lenght ends in the middle of a word.
     * @param string $terminator The ellipsis terminator to use for the text.
     * @return string
     */
    public function truncate($text, $length, $terminator = ' ...')
    {
        while (mb_substr($text, $length, 1) != ' ' && $length > 0) {
            $length--;
        }
        return mb_substr($text, 0, $length) . $terminator;
    }

    public function __destruct()
    {
        StringStream::unregister();
    }

}
