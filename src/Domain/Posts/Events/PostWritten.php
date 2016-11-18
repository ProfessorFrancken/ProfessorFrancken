<?php

declare(strict_types=1);

namespace Francken\Domain\Posts\Events;

use Francken\Domain\Posts\PostId;
use Francken\Domain\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class PostWritten implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $title;
    private $content;
    private $type;
    // private $authorId;

    public function __construct(PostId $postId, $title, $content, $type/*, $authorId*/)
    {
        $this->postId = $postId;
        $this->title = $title;
        $this->content = $content;
        $this->type = $type;
        // $this->authorId = $authorId;
    }

    public function postId()
    {
        return $this->postId;
    }

    public function title()
    {
        return $this->title;
    }

    public function content()
    {
        return $this->content;
    }

    public function type()
    {
        return $this->type;
    }

    // public function authorId()
    // {
    //     return $this->authorId;
    // }

    protected static function deserializationCallbacks()
    {
        return [
            'postId' => [PostId::class, 'deserialize']
        ];
    }
}
