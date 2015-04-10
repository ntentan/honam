<?php
namespace ntentan\honam\template_engines\php;

use ntentan\honam\template_engines\TemplateEngine;

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

        $helpers = $this->helpers;
        $widgets = $this->widgets;       

        ob_start();
        include $this->template;
        return ob_get_clean();
    }

    public function strip($text)
    {
        return \ntentan\utils\Janitor::cleanHtml($text, true);
    }

    public function truncate($text, $length, $terminator = ' ...')
    {
        while(mb_substr($text, $length, 1) != ' ' && $length > 0)
        {
            $length--;
        }
        return mb_substr($text, 0, $length) . $terminator;
    }
}

