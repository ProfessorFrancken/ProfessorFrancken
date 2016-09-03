<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Committees;

use DateTimeImmutable;
use Francken\Tests\Application\ReadModelTestCase as TestCase;
use Francken\Application\ReadModel\PostList\PostList;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Posts\PostId;

class PostsListTest extends TestCase
{
    /** @test */
    function it_has_getters()
    {
        $id = PostId::generate();
        $member = MemberId::generate();

        $post = new PostList(
            $id,
            $member,
            'My Title',
            'My Content',
            'blog',
            new DateTimeImmutable('2016-09-02T10:14:05')
        );

        $this->assertEquals($id, $post->id());
        $this->assertEquals($member, $post->authorId());
        $this->assertEquals('My Title', $post->title());
        $this->assertEquals('My Content', $post->content());
        $this->assertEquals('blog', $post->type());
        $this->assertEquals(new DateTimeImmutable('2016-09-02T10:14:05'), $post->publishedAt());
    }


    protected function createInstance()
    {
        return new PostList(
            PostId::generate(),
            MemberId::generate(),
            'My Title',
            'My Content',
            'blog',
            new DateTimeImmutable('2016-09-02T10:14:05')
        );
    }
}
