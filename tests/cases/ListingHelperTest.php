<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\HelperTestCase;

class ListingHelperTest extends HelperTestCase
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
    }
}

