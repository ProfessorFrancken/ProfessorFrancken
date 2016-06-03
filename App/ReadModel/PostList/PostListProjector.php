<?php

namespace App\ReadModel\PostList;

use App\ReadModel\PostList\PostList;
use Broadway\ReadModel\Projector;

use Francken\Posts\Events\PostWritten;
use Francken\Posts\Events\PostTitleChanged;
use Francken\Posts\Events\PostContentChanged;
use Francken\Posts\Events\PostCategorized;
use Francken\Posts\Events\PostPublishedAt;

final class PostListProjector extends Projector
{
    public function applyPostWritten(PostWritten $event)
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

    public function applyPostTitleChanged(PostTitleChanged $event)
    {
        PostList::where('uuid', $event->postId())
            ->update('title', $event->title());
    }

    public function applyPostContentChanged(PostContentChanged $event)
    {
        PostList::where('uuid', $event->postId())
            ->update('content', $event->content());
    }

    public function applyPostCategorized(PostCategorized $event)
    {
        PostList::where('uuid', $event->postId())
            ->update('type', $event->type());
    }

    public function applyPostPublishedAt(PostPublishedAt $event)
    {
        $post = PostList::where('uuid', $event->postId())->first();
        $post->published_at = $event->date();
        $post->save();
    }
}
