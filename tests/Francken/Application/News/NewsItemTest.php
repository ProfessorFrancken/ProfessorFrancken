<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Committees;

use DateTimeImmutable;
use Francken\Tests\Application\ReadModelTestCase as TestCase;
use Francken\Application\News\NewsItem;
use Francken\Domain\Members\MemberId;

class NewsItemsTest // extends TestCase
{

    /*
     * TODO: Add Author, AuthorID (containing either member, committee or board)
     * Add NewsId
     */



    //    /** @test */
    function it_has_getters()
    {
        $id = NewsItemId::generate();
        $member = MemberId::generate();

        $newsItem = new NewsItem(
            $id,
            $member,
            'My Title',
            'My Content',
            'blog',
            new DateTimeImmutable('2016-09-02T10:14:05')
        );

        $this->assertEquals($id, $newsItem->id());
        $this->assertEquals($member, $newsItem->authorId());
        $this->assertEquals('My Title', $newsItem->title());
        $this->assertEquals('My Content', $newsItem->content());
        $this->assertEquals('blog', $newsItem->type());
        $this->assertEquals(new DateTimeImmutable('2016-09-02T10:14:05'), $newsItem->publishedAt());
    }


    protected function createInstance()
    {
        return new NewsItem(
            NewsItemId::generate(),
            MemberId::generate(),
            'My Title',
            'My Content',
            'blog',
            new DateTimeImmutable('2016-09-02T10:14:05')
        );
    }
}
