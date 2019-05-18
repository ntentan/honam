<?php

namespace ntentan\honam\tests\cases;

class HelperTest extends \ntentan\honam\tests\lib\HelperTestCase
{
    public function testPlugin()
    {
        require 'tests/mocks/helper_plugin/TestHelperPlugin.php';
        $this->helpers->test->test(array());
    }
}
