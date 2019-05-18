<?php

namespace ntentan\honam\tests\cases;

/**
 * Description of MenuHelperTest
 *
 * @author ekow
 */
class MenuHelperTest extends \ntentan\honam\tests\lib\HelperTestCase
{
    public function testMenu()
    {
        $this->assertXmlStringEqualsXmlString(
        file_get_contents('tests/files/markup/menu_render.html'),
            (string)$this->helpers->menu(
                array(
                    'Home', 'Projects', 'Blog', 'About'
                )
            )
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
            (string)$this->helpers->menu(
                array(
                    'Home', 'Projects', 'Blog', 'About'
                )
            )->addCSSClass('styling')->setAlias('side_menu')
        );
    }    
    
    public function testMenuMatching()
    {
        $this->assertXmlStringEqualsXmlString(
        file_get_contents('tests/files/markup/menu_matched.html'),
            (string)$this->helpers->menu(
                array(
                    'Home', 'Projects', 'Blog', 'About'
                )
            )->setCurrentUrl('about')
        );    
    }   
}
