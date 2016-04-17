<?php

namespace Francken\Posts;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Posts\PostId;
use Francken\Posts\Events\PostWritten;

class Post extends EventSourcedAggregateRoot
{
    private $id;
    private $title;
    private $content;
    private $type;
    private $authorId;
    private $publishedAt;
    private $isDraft = true;

    // types: PHP needs enums...
    const BLOGPOST = 'blog';
    const NEWSPOST = 'news';

    public static function create(PostId $id, string $title, string $content)
    {
        $post = new Post;
        $post->apply(new PostWritten($id, $title, $content));
        return $post;
    }

    public function edit()
    {
        
    }

    public function categorize()
    {
        
    }

    public function publish()
    {
        //check is not already published
        $this->apply(new PostPublished($id));
    }

    public function remove()
    {
        $this->apply(new PostRemoved($id));
    }

    public function applyPostWritten(PostWritten $event)
    {
        $this->id = $event->PostId();
        $this->title = $event->title();
        $this->content = $event->content();
        // $this->type = $event->type();
        // $this->authorId = $event->authorId();
    }

    public function applyPostPublished(PostPublished $event)
    {
        $this->isDraft = false;
    }

    public function applyPostRemoved(PostRemoved $event)
    {
        $this->isDraft = true;
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }
}
