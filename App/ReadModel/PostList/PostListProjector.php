<?php

namespace App\ReadModel\PostList;

use App\ReadModel\PostList\PostList;
use Broadway\ReadModel\Projector;

use Francken\Posts\Events\PostWritten;

final class PostListProjector extends Projector
{
    public function applyPostWritten(PostWritten $event)
    {
        ///@todo: change authorId to author name
        $post = PostList::create([
                "uuid" => $event->PostId(),
                "title" => $event->title(),
                "content" => $event->content()//,
                // "type" => $event->type(),
                // "authorId" => $event->authorId()
            ]);

        $post->save();
    }
}
