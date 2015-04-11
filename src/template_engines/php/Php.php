<?php
namespace ntentan\honam\template_engines\php;

use ntentan\honam\template_engines\TemplateEngine;

require_once 'functions.php';

/**
 * The PHP engine is a template engine built into honam which uses raw PHP as
 * the template language. By virtue of this, the PHP engine can boast of high
 * performance. Since this engine uses PHP, it has access to all the language's
 * features. This could sometimes create a problem since some of these features
 * are not intended for templating use.
 */
class Php extends TemplateEngine
{
    public function generate($templateData)
    {
        // Escape each variable by passing it through the variable class.
        // Users would have to unescape them by calling the escape method directly
        // on the variable.
        foreach($templateData as $key => $value)
        {
            $$key = Variable::initialize($value);
        }

        // Expose helpers and widgets
        $helpers = $this->helpers;
        $widgets = $this->widgets;       

        // Start trapping the output buffer and include the PHP template for
        // execution.
        ob_start();
        try{
            include $this->template;
        }
        catch(\Exception $e)
        {
            ob_get_flush();
            throw $e;
        }
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
        return Janitor::cleanHtml($text, true);
    }

    /**
     * A utility function to cut long pieces of text into meaningful short
     * chunks. The function is very good in cases where you want to show just
     * a short preview snippet of a long text. The function cuts the long string
     * without cutting through words and appends some sort of ellipsis
     * terminator to the text.
     * 
     * @param string $text The text to be truncated.
     * @param string $length The maximum lenght of the truncated string. Might 
     *      return a shorter string if the lenght ends in the middle of a word.
     * @param string $terminator The ellipsis terminator to use for the text.
     * @return string
     */
    public function truncate($text, $length, $terminator = ' ...')
    {
        while(mb_substr($text, $length, 1) != ' ' && $length > 0)
        {
            $length--;
        }
        return mb_substr($text, 0, $length) . $terminator;
    }
}

