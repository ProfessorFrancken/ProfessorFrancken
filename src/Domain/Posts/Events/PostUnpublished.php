<?php

namespace Francken\Domain\Posts\Events;

use Francken\Domain\Posts\PostId;
use Francken\Domain\Base\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class PostUnpublished implements SerializableInterface
{
    use Serializable;

    private $postId;

    public function __construct(PostId $postId)
    {
        $this->postId = $postId;
    }

    public function postId() : PostId
    {
        return $this->postId;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'postId' => [PostId::class, 'deserialize']
        ];
    }
}
