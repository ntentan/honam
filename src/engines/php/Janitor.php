<?php

namespace ntentan\honam\engines\php;

/**
 * A class which contains methods for cleaning out contents and making them
 * safe.
 */
class Janitor
{
    /**
     * A utility method which either strips html tags or escapes them.
     *
     * @param string $string The string to be cleaned
     * @param boolean $strip When true the tags are stripped instead of being escaped.
     * @return string
     */
    public function cleanHtml($string, $strip = false)
    {
        if ($strip === false) {
            return htmlspecialchars((string)$string);
        } else {
            return strip_tags((string)$string);
        }
    }
}