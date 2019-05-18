<?php
namespace ntentan\honam\tests\cases;

use ntentan\honam\tests\lib\HelperBaseTest;

class FeedHelperTest extends HelperBaseTest
{    

    public function setUp() : void
    {
        parent::setUp();
        date_default_timezone_set('UTC');
    }

    public function testRSSFeed()
    {        
        $rssFeed = $this->helpers->feed->setItems(
            array(
                array(
                    'title' => 'Some Item',
                    'url' => 'http://someurl.net/something',
                    'summary' => 'This is a brief story for you to understand why we did this',
                    'author' => 'author@honam.ntentan',
                    'category' => 'Sports',
                    'date' => '2014-12-01 13:45:23 UTC'
                ),
                array(
                    'title' => 'Some HTML Item',
                    'url' => 'http://someurl.net/something_html',
                    'summary' => '<b>Has HTML</b><p>This is a brief story for you to understand why we did this</p>',
                    'author' => 'author@honam.ntentan',
                    'category' => 'Sports',
                    'date' => '2014-12-02 13:45:23 UTC'
                )                
            )
        )
        ->setTitle('Test RSS Feed')
        ->setUrl('http://someurl.net')
        ->setUpdated('2014-12-01 14:23:36 UTC')
        ->setDescription('The blog of honam tests');
        $this->assertXmlStringEqualsXmlString(file_get_contents('tests/files/feeds/rss_feed.xml'), (string)$rssFeed);
    }
    
    public function testRSSFeed2()
    {
        $rssFeed = $this->helpers->feed(
            array(
                array(
                    'title' => 'Some Item',
                    'url' => 'http://someurl.net/something',
                    'summary' => 'This is a brief story for you to understand why we did this',
                    'author' => 'author@honam.ntentan',
                    'category' => 'Sports',
                    'date' => '2014-12-01 13:45:23'
                ),
                array(
                    'title' => 'Some HTML Item',
                    'url' => 'http://someurl.net/something_html',
                    'summary' => '<b>Has HTML</b><p>This is a brief story for you to understand why we did this</p>',
                    'author' => 'author@honam.ntentan',
                    'category' => 'Sports',
                    'date' => '2014-12-02 13:45:23'
                )                
            )
        )
        ->setTitle('Test RSS Feed')
        ->setUrl('http://someurl.net')
        ->setUpdated('2014-12-01 14:23:36')
        ->setDescription('The blog of honam tests');
        
        $this->assertXmlStringEqualsXmlString(file_get_contents('tests/files/feeds/rss_feed.xml'), (string)$rssFeed);
    }    
    
    public function testRSSFeedGUIDGenerate()
    {
        $rssFeed = $this->helpers->feed->setItems(
            array(
                array(
                    'title' => 'Some Item',
                    'summary' => 'This is a brief story for you to understand why we did this',
                    'author' => 'author@honam.ntentan',
                    'category' => 'Sports',
                    'date' => '2014-12-01 13:45:23'
                ),
                array(
                    'title' => 'Some HTML Item',
                    'summary' => '<b>Has HTML</b><p>This is a brief story for you to understand why we did this</p>',
                    'author' => 'author@honam.ntentan',
                    'category' => 'Sports',
                    'date' => '2014-12-02 13:45:23'
                )                
            )
        )
        ->setTitle('Test RSS Feed')
        ->setUrl('http://someurl.net')
        ->setUpdated('2014-12-01 14:23:36')
        ->setDescription('The blog of honam tests');
        $this->assertXmlStringEqualsXmlString(file_get_contents('tests/files/feeds/rss_feed_guid.xml'), (string)$rssFeed);
    }
}
