<?php

namespace ntentan\honam\tests\cases;

/**
 * Description of MenuHelperTest
 *
 * @author ekow
 */
class MenuHelperTest extends \ntentan\honam\tests\lib\HelperBaseTest
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
}
