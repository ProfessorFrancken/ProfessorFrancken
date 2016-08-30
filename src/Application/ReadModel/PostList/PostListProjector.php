<?php

namespace Francken\Application\ReadModel\PostList;

use Francken\Application\Projector;
use Francken\Application\ReadModel\PostList\PostList;
use Francken\Posts\Events\PostCategorized;
use Francken\Posts\Events\PostContentChanged;
use Francken\Posts\Events\PostPublishedAt;
use Francken\Posts\Events\PostTitleChanged;
use Francken\Posts\Events\PostWritten;

final class PostListProjector extends Projector
{
    public function whenPostWritten(PostWritten $event)
    {
        ///@todo: change authorId to author name
        $post = PostList::create([
                "uuid" => $event->PostId(),
                "title" => $event->title(),
                "content" => $event->content(),
                "type" => $event->type()
                // "authorId" => $event->authorId()
            ]);
    }

    public function whenPostTitleChanged(PostTitleChanged $event)
    {
        PostList::where('uuid', $event->postId())
            ->update('title', $event->title());
    }

    public function whenPostContentChanged(PostContentChanged $event)
    {
        PostList::where('uuid', $event->postId())
            ->update('content', $event->content());
    }

    public function whenPostCategorized(PostCategorized $event)
    {
        PostList::where('uuid', $event->postId())
            ->update('type', $event->type());
    }

    public function whenPostPublishedAt(PostPublishedAt $event)
    {
        $post = PostList::where('uuid', $event->postId())->first();
        $post->published_at = $event->date();
        $post->save();
    }
}
