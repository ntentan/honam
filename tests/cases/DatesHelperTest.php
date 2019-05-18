<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\HelperBaseTest;

class DatesHelperTest extends HelperBaseTest
{    
    public function testDateHelpers()
    {
        $this->assertEquals("1st January, 2015", $this->helpers->date('2015-01-01'));
        $this->assertEquals("1st January, 2015", $this->helpers->date('2015-01-01 12:00:00'));
        $this->assertEquals("12:00 pm", $this->helpers->date->time());
        $this->assertEquals("now", $this->helpers->date('2015-01-01 11:59:55')->sentence(false, '2015-01-01 12:00:00'));
        $this->assertEquals("now", $this->helpers->date('2015-01-01 11:59:55')->sentence(true, '2015-01-01 12:00:00'));
        $this->assertEquals("11 seconds", $this->helpers->date('2015-01-01 11:59:49')->sentence(false, '2015-01-01 12:00:00'));
        $this->assertEquals("10 minutes", $this->helpers->date('2015-01-01 11:50:00')->sentence(false, '2015-01-01 12:00:00'));
        $this->assertEquals("1 minute", $this->helpers->date('2015-01-01 11:59:00')->sentence(false, '2015-01-01 12:00:00'));
        $this->assertEquals("1 hour", $this->helpers->date('2015-01-01 11:00:00')->sentence(false, '2015-01-01 12:00:00'));
        $this->assertEquals("2 hours", $this->helpers->date('2015-01-01 10:00:00')->sentence(false, '2015-01-01 12:00:00'));
        $this->assertEquals("yesterday", $this->helpers->date('2014-12-31 12:00:00')->sentence(false, '2015-01-01 12:00:00'));
        $this->assertEquals("tomorrow", $this->helpers->date('2015-01-02 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("2 days", $this->helpers->date('2015-01-03 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("1 week", $this->helpers->date('2015-01-08 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("2 weeks", $this->helpers->date('2015-01-20 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("1 month", $this->helpers->date('2015-02-20 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("2 months", $this->helpers->date('2015-03-20 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("1 year", $this->helpers->date('2014-01-01 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("2 years", $this->helpers->date('2013-01-01 12:00:00')->sentence(false, '2015-01-01 12:00:00'));        
        $this->assertEquals("2 years ago", $this->helpers->date('2013-01-01 12:00:00')->sentence(true, '2015-01-01 12:00:00'));        
        $this->assertEquals("in 2 years", $this->helpers->date('2015-01-01 12:00:00')->sentence(true, '2013-01-01 12:00:00'));        
    }
}
