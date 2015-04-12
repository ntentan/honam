<?php
/*
 * Dates helper
 * 
 * Ntentan Framework
 * Copyright (c) 2008-2012 James Ekow Abaka Ainooson
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
 * 
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright Copyright 2010 James Ekow Abaka Ainooson
 * @license MIT
 */



namespace ntentan\honam\helpers\date;

use ntentan\honam\helpers\Helper;

/**
 * A view helper for formatting dates.
 *
 * @author James Ekow Abaka Ainooson
 */
class DateHelper extends Helper
{
    /**
     * The UNIX timestamp which represents the most recently parsed date.
     * @var integer
     */
    private $timestamp;
    
    /**
     * Internal utility method for selecting a timestamp. This method returns
     * the DatesHelper::timestamp variable if the date parameter is null. This
     * method makes it possible for the helper methods to use either the
     * internally stored timestamp (which is stored by the DatesHelper::parse
     * method) or the date passed directly to the helper method.
     *
     * @param string $date
     * @return integer
     */
    private function selectTimestamp($date = null)
    {
        return $date == null ? $this->timestamp : strtotime($date);
    }

    /**
     * Parse a time in string format and store. Once parsed, all calls to helper
     * methods which do not specify their own dates use the last date which was
     * parsed.
     * 
     * @param string $time
     * @return DatesHelper
     */
    public function help($time)
    {
        $this->timestamp =strtotime($time);
        return $this;
    }

    /**
     * A wrapper arround the PHP date() method. This method however takes the
     * dates in various string formats.
     *
     * @param string $format
     * @param string $date
     * @return string
     */
    public function format($format = 'jS F, Y', $date = null)
    {
        return date($format, $this->selectTimestamp($date));
    }

    /**
     * Returns date in the format 12:00 am
     * 
     * @param string $date
     * @return string
     */
    public function time($date = null)
    {
        return date("g:i a", $this->selectTimestamp($date));
    }

    /**
     * Provides a nice sentence to represents the date in age terms eg. Three Years,
     * Two days or now. The first argument is a structured array of options.
     * Currently this argument has one option which also has just one possible
     * value. This option is the <code>elaborate_with</code> option which currently
     * only takes the english word <code>ago</code> as its parameter. When this
     * argument is passed, the word 'ag'o is appended to sentences for which it
     * would make sense. For example the outputs with this argument could be
     * (two days ago, one month ago, now, yesterday, three minutes ago ...)
     *
     * @code
     * $this->date->parse(date('Y-m-d))->sentence(array('elaborate_with'=>'ago'));
     * @endcode
     * 
     * @todo Base on date object instead of doing math with time.
     * @param boolean $ago
     * @param string $referenceDate
     * @return string
     */
    public function sentence($ago = false, $referenceDate = null)
    {
        $timestamp = $this->selectTimestamp();
        $now = $referenceDate == null ? time() : strtotime($referenceDate);
        $elapsed = $now - $timestamp;
        
        $future = $elapsed < 0;
        $elapsed = abs($elapsed);
        
        if($elapsed < 10)
        {
            $englishDate = 'now';
        }
        elseif($elapsed >= 10 && $elapsed < 60)
        {
            $englishDate = "$elapsed seconds";
        }
        elseif($elapsed >= 60 && $elapsed < 3600)
        {
            $minutes = floor($elapsed / 60);
            $englishDate = "$minutes minute" . ($minutes > 1 ? 's' : '');
        }
        elseif($elapsed >= 3600 && $elapsed < 86400)
        {
            $hours = floor($elapsed / 3600);
            $englishDate = "$hours hour" . ($hours > 1 ? 's' : '');
        }
        elseif($elapsed >= 86400 && $elapsed < 172800)
        {
            if($future)
            {
                $englishDate = "tomorrow";
            }
            else
            {
                $englishDate = "yesterday";
            }
        }
        elseif($elapsed >= 172800 && $elapsed < 604800)
        {
            $days = floor($elapsed / 86400);
            $englishDate = "$days day" . ($days > 1 ? 's' : '');
        }
        elseif($elapsed >= 604800 && $elapsed < 2419200)
        {
            $weeks = floor($elapsed / 604800);
            $englishDate = "$weeks week" . ($weeks > 1 ? 's' : '');
        }
        elseif($elapsed >= 2419200 && $elapsed < 31536000)
        {
            $months = floor($elapsed / 2419200);
            $englishDate = "$months month" . ($months > 1 ? 's' : '');
        }
        elseif($elapsed >= 31536000)
        {
            $years = floor($elapsed / 31536000);
            $englishDate = "$years year" . ($years > 1 ? 's' : '');
        }

        if($englishDate != 'now' && $englishDate != 'yesterday' && $englishDate != 'today' && $ago)
        {
            if($future) 
            {
                $englishDate = 'in '. $englishDate;
            }
            else 
            {
                $englishDate .= ' ago';
            }
        }

        return $englishDate;
    }
    
    public function __toString() {
        return $this->format();
    }
}
