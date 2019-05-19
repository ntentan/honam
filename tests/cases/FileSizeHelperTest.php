<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\HelperTestCase;

class FileSizeHelperTest extends HelperTestCase
{    
    public function testFileSizes()
    {
        $this->assertEquals('1,000 Bytes', (string)$this->helpers->filesize('1000'));
        $this->assertEquals('1 Byte', (string)$this->helpers->filesize('1'));
        $this->assertEquals('1.00 Kilobyte', (string)$this->helpers->filesize('1024'));
        $this->assertEquals('1.76 Kilobytes', (string)$this->helpers->filesize('1800'));
    }
}
