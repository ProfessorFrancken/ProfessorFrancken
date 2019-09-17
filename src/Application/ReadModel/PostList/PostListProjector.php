<?php

declare(strict_types=1);

namespace Francken\Application\ReadModel\PostList;

use DateTimeImmutable;
use Francken\Application\Projector;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Posts\Events\PostCategorized;
use Francken\Domain\Posts\Events\PostContentChanged;
use Francken\Domain\Posts\Events\PostPublishedAt;
use Francken\Domain\Posts\Events\PostTitleChanged;
use Francken\Domain\Posts\Events\PostWritten;

final class PostListProjector extends Projector
{
    private $posts;

    public function __construct(PostListRepository $posts)
    {
        $this->posts = $posts;
    }

    public function whenPostWritten(PostWritten $event) : void
    {
        $post = new PostList(
            $event->postId(),
            new MemberId('6703202d-6556-404d-988c-b76c5a34b97c'),
            $event->title(),
            $event->content(),
            $event->type(),
            new DateTimeImmutable('2016-09-02T10:14:05')
        );

        $this->posts->save($post);
    }

    public function whenPostTitleChanged(PostTitleChanged $event) : void
    {
        $post = $this->posts->find($event->postId());

        $this->posts->save(
            new PostList(
                $post->id(),
                $post->authorId(),
                $event->title(),
                $post->content(),
                $post->type(),
                $post->publishedAt()
            )
        );
    }

    public function whenPostContentChanged(PostContentChanged $event) : void
    {
        $post = $this->posts->find($event->postId());

        $this->posts->save(
            new PostList(
                $post->id(),
                $post->authorId(),
                $post->title(),
                $event->content(),
                $post->type(),
                $post->publishedAt()
            )
        );
    }

    public function whenPostCategorized(PostCategorized $event) : void
    {
        $post = $this->posts->find($event->postId());

        $this->posts->save(
            new PostList(
                $post->id(),
                $post->authorId(),
                $post->title(),
                $post->content(),
                $event->type(),
                $post->publishedAt()
            )
        );
    }

    public function whenPostPublishedAt(PostPublishedAt $event) : void
    {
        $post = $this->posts->find($event->postId());

        $this->posts->save(
            new PostList(
                $post->id(),
                $post->authorId(),
                $post->title(),
                $post->content(),
                $post->type(),
                $event->publishedAt()
            )
        );
    }
}
