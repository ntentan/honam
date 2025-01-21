<?php

namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\HelperTestCase;

/**
 * @author ekow
 */
class MenuHelperTest extends HelperTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $_SERVER['REQUEST_URI'] = ""; // Set this to an empty string
    }

    public function testMenu()
    {
        $this->assertXmlStringEqualsXmlString(
        file_get_contents('tests/files/markup/menu_render.html'),
            (string)$this->helpers->menu(
                array(
                    'Home', 'Projects', 'Blog', 'About'
                )
            )->__toString()
        );
    }
    
    public function testMenuNoLink()
    {   
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/menu_no_links.html'),
            (string)$this->helpers->menu(
                array(
                    'Home', 'Projects', 'Blog', 'About'
                )
            )->setHasLinks(false)
        );
    }    
    
    public function testMenuStyling()
    {
        $this->assertXmlStringEqualsXmlString(
        file_get_contents('tests/files/markup/menu_styling.html'),
            (string) $this->helpers->menu(
                array(
                    'Home', 'Projects', 'Blog', 'About'
                )
            )->addCSSClass('styling')->setAlias('side_menu')
        );
    }
}
