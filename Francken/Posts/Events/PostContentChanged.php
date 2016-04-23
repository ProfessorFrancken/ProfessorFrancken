<?php

namespace Francken\Posts\Events;

use Francken\Posts\PostId;
use Francken\Base\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class PostContentChanged implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $content;

    public function __construct(PostId $postId, string $content)
    {
        $this->postId = $postId;
    }

    public function postId() : PostId
    {
        return $this->postId;
    }

    public function content() : string
    {
        return $this->content;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'postId' => [PostId::class, 'deserialize']
        ];
    }
}
