<?php

namespace ntentan\views\tests\cases;

class HelperTest extends \ntentan\views\tests\lib\HelperBaseTest
{
    /**
     * @expectedException \ntentan\views\exceptions\HelperException
     */    
    public function testUnknownHelper()
    {
        $this->helpers->fake();
    }
    
    public function testPlugin()
    {
        require 'tests/mocks/helper_plugin/TestHelperPlugin.php';
        $this->helpers->test->test(array());
    }
}
