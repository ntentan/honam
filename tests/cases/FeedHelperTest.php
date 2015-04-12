<?php
namespace ntentan\honam\tests\cases;

class FeedHelperTest extends \ntentan\honam\tests\lib\HelperBaseTest
{    
    public function testRSSFeed()
    {
        $rssFeed = $this->helpers->feed->items(
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
        ->title('Test RSS Feed')
        ->url('http://someurl.net')
        ->updated('2014-12-01 14:23:36')
        ->description('The blog of honam tests')
        ->generate('rss');
        
        $this->assertXmlStringEqualsXmlString(file_get_contents('tests/files/feeds/rss_feed.xml'), $rssFeed);
    }
}
