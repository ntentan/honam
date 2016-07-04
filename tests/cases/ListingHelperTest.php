<?php
namespace ntentan\honam\tests\cases;

class ListingHelperTest extends \ntentan\honam\tests\lib\HelperBaseTest
{
    public function testList()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/listing_helper.html'),           
            (string)$this->helpers->listing(array(
                    'data' => array(
                        array(
                            'name' => 'Harry Porter',
                            'house' => 'Gryfindor'
                        )
                    ),
                    'headers' => array(
                        'Name',
                        'House'
                    )
                )
            )
        );
        
        $this->assertFileExists($this->helpers->listing->stylesheet());
    }
}

