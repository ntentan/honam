<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\HelperTestCase;

class PainationHelperTest extends HelperTestCase
{
    public function testPlainPagination()
    {
        $this->assertXmlStringEqualsXmlString(
            "<ul class='pagination'></ul>", 
            (string)$this->helpers->pagination()->__toString()
        );
    }
    
    public function testPagination()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/pagination_1.html'),
            (string)$this->helpers->pagination(
                array(
                    'number_of_pages' => 45,
                    'base_url' => '/stories/page/'
                )
            )
        );
    }    
    
    public function testPaginationPage()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/pagination_2.html'),
            (string)$this->helpers->pagination(
                array(
                    'number_of_pages' => 45,
                    'page_number' => 20,
                    'base_url' => '/stories/page/'
                )
            )
        );
    }       
    
    public function testPaginationPageQuery()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/pagination_3.html'),
            (string)$this->helpers->pagination(
                array(
                    'number_of_pages' => 45,
                    'query' => 'page',
                    'base_url' => '/stories/page/'
                )
            )
        );
    }          
    
    public function testPaginationPageAgain()
    {
        $this->assertXmlStringEqualsXmlString(
            file_get_contents('tests/files/markup/pagination_4.html'),
            (string)$this->helpers->pagination(
                array(
                    'number_of_pages' => 45,
                    'page_number' => 40,
                    'base_url' => '/stories/page/'
                )
            )
        );
    }       
}
