<?php
namespace ntentan\views\tests\cases;

use ntentan\views\TemplateEngine;

class PhpEngineTest extends \ntentan\views\tests\lib\ViewBaseTest
{    
    public function testStrip()
    {
        $output = TemplateEngine::render('phptest_strip.tpl.php', array());
        $this->assertEquals("This should strip", $output);
    }
    
    public function testTruncate()
    {
        $output = TemplateEngine::render('phptest_truncate.tpl.php', array());
        $this->assertEquals("The quick ...", $output);
    }
    
    public function testVariableUnescape()
    {
        $output = TemplateEngine::render('phptest_variable.tpl.php', array('some_html' => "<div><span>Hello I'm HTML</span></div>"));
        $this->assertEquals("&lt;div&gt;&lt;span&gt;Hello I'm HTML&lt;/span&gt;&lt;/div&gt; : <div><span>Hello I'm HTML</span></div>", $output);
    }
    
    public function testArrayVariable()
    {
        $output = TemplateEngine::render(
            'phptest_array.tpl.php',
            array(
                'array' => array(
                    'first' => '<div>Number one</div>',
                    'second' => '<b>Number two</b>',
                    'third' => '<span>Number three</span>'
                )
            )
        );
        $expected = "&lt;div&gt;Number one&lt;/div&gt; <div>Number one</div> first 
&lt;b&gt;Number two&lt;/b&gt; <b>Number two</b> second 
&lt;span&gt;Number three&lt;/span&gt; <span>Number three</span> third 
&lt;div&gt;Number one&lt;/div&gt; <div>Number one</div> 
second found
&lt;p&gt;A new paragraph&lt;/p&gt; <p>A new paragraph</p> 
&lt;p&gt;A zero paragraph&lt;/p&gt; <p>A zero paragraph</p> 

";
        $this->assertEquals($expected, $output);
    }
}
