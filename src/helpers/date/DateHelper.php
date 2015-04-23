<?php
/*
 * Ntentan Framework
 * Copyright (c) 2008-2015 James Ekow Abaka Ainooson
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
 */

namespace ntentan\views\helpers\date;

use ntentan\views\helpers\Helper;

/**
 * A view helper for formatting dates. This helper provides 
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
        $this->timestamp = strtotime($time);
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
     * Two days or now. The first argument is a boolean which qualifies the date
     * with a relativity word (like ago) which gives the date a sense of passing
     * time. For example the outputs with this argument could be
     * (two days ago, one month ago, now, yesterday, three minutes ago ...)
     *
     * ````php
     * <?php
     * $helpers->date('2015-01-01')->sentence(true);
     * ````
     * 
     * @param boolean $ago
     * @param string $referenceDate
     * @return string
     */
    public function sentence($ago = false, $referenceDate = null)
    {
        $timestamp = $this->selectTimestamp();
        $now = $referenceDate === null ? time() : strtotime($referenceDate);
        $elapsed = $now - $timestamp;
        
        $future = $elapsed < 0;
        $elapsed = abs($elapsed);
        $englishDate = '';
        
        $timeFrames = array(
            array(
                'min' => 0,
                'max' => 10,
                'scale' => 'now',
                'plurals' => false,
                'divisor' => 1,
                'has_future' => false,
                'show_elapsed' => false
            ),
            array(
                'min' => 10,
                'max' => 60,
                'scale' => 'second',
                'plurals' => true,
                'divisor' => 1,
                'has_future' => false,
                'show_elapsed' => true
            ),            
            array(
                'min' => 60,
                'max' => 3600,
                'scale' => 'minute',
                'plurals' => true,
                'divisor' => 60,
                'has_future' => false,
                'show_elapsed' => true
            ),                        
            array(
                'min' => 3600,
                'max' => 86400,
                'scale' => 'hour',
                'plurals' => true,
                'divisor' => 3600,
                'has_future' => false,
                'show_elapsed' => true
            ),    
            array(
                'min' => 86400,
                'max' => 172800,
                'scale' => array('yesterday', 'tomorrow'),
                'has_future' => true,
                'plurals' => false,
                'divisor' => 86400,
                'show_elapsed' => false
            ),  
            array(
                'min' => 172800,
                'max' => 604800,
                'scale' => 'day',
                'plurals' => true,
                'divisor' => 86400,
                'has_future' => false,
                'show_elapsed' => true
            ),              
            array(
                'min' => 604800,
                'max' => 2419200,
                'scale' => 'week',
                'plurals' => true,
                'divisor' => 604800,
                'has_future' => false,
                'show_elapsed' => true
            ),              
            array(
                'min' => 2419200,
                'max' => 31536000,
                'scale' => 'month',
                'plurals' => true,
                'divisor' => 2419200,
                'has_future' => false,
                'show_elapsed' => true
            ),   
            array(
                'min' => 31536000,
                'max' => 0,
                'scale' => 'year',
                'plurals' => true,
                'divisor' => 31536000,
                'has_future' => false,
                'show_elapsed' => true
            ),               
        );
        
        foreach($timeFrames as $timeFrame)
        {
            if(($elapsed >= $timeFrame['min'] && $elapsed < $timeFrame['max']) || ($elapsed >= $timeFrame['min'] && $timeFrame['max'] === 0))
            {
                $value = floor($elapsed / $timeFrame['divisor']);
                $englishDate = $this->getEnglishDate($timeFrame, $value, $future);
                break;
            }
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
    
    private function getEnglishDate($timeFrame, $value, $future)
    {
        return ($timeFrame['show_elapsed'] ?  "$value " : '') .
            ($timeFrame['has_future'] ? ($future ? $timeFrame['scale'][1] : $timeFrame['scale'][0]) : "{$timeFrame['scale']}") . 
            ($timeFrame['plurals'] && $value > 1 ? 's' : '');        
    }
    
    public function __toString() {
        return $this->format();
    }
}
