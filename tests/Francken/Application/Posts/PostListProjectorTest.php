<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Posts;

use DateTimeImmutable;
use Francken\Application\Projector;
use Francken\Application\ReadModel\PostList\PostList;
use Francken\Application\ReadModel\PostList\PostListProjector;
use Francken\Domain\Posts\Events\PostCategorized;
use Francken\Domain\Posts\Events\PostContentChanged;
use Francken\Domain\Posts\Events\PostPublishedAt;
use Francken\Domain\Posts\Events\PostTitleChanged;
use Francken\Domain\Posts\Events\PostWritten;
use Francken\Domain\Posts\PostId;
use Francken\Domain\Members\MemberId;
use Francken\Infrastructure\Repositories\InMemoryRepository;
use Francken\Tests\Application\ProjectorScenarioTestCase as TestCase;

class PostListProjectorTest extends TestCase
{
    /** @test */
    function it_stores_posts()
    {
        // Currently hardcoding published at and member id
        $id = PostId::generate();
        $member = new MemberId('6703202d-6556-404d-988c-b76c5a34b97c');

        $this->scenario->when(
            new PostWritten($id, 'My Title', 'My Content', 'blog')
        )->then([
            new PostList(
                $id,
                $member,
                'My Title',
                'My Content',
                'blog',
                new DateTimeImmutable('2016-09-02T10:14:05')
            )
        ]);
    }

    /** @test */
    function it_changes_the_contents_of_a_post()
    {
        // Currently hardcoding published at and member id
        $id = PostId::generate();
        $member = new MemberId('6703202d-6556-404d-988c-b76c5a34b97c');

        $this->scenario->given([
            new PostWritten($id, 'My Title', 'My Content', 'blog')
        ])->when(
            new PostTitleChanged($id, 'New Title')
        )->then([
            new PostList(
                $id,
                $member,
                'New Title',
                'My Content',
                'blog',
                new DateTimeImmutable('2016-09-02T10:14:05')
            )
        ])->when(
            new PostContentChanged($id, 'New Content')
        )->then([
            new PostList(
                $id,
                $member,
                'New Title',
                'New Content',
                'blog',
                new DateTimeImmutable('2016-09-02T10:14:05')
            )
        ]);
    }

    protected function createProjector(InMemoryRepository $repository) : Projector
    {
        return new PostListProjector($repository);
    }
}
