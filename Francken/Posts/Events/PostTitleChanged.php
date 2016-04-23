<?php

namespace Francken\Posts\Events;

use Francken\Posts\PostId;
use Francken\Base\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class PostTitleChanged implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $title;

    public function __construct(PostId $postId, string $title)
    {
        $this->postId = $postId;
    }

    public function postId() : PostId
    {
        return $this->postId;
    }

    public function title() : string
    {
        return $this->title;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'postId' => [PostId::class, 'deserialize']
        ];
    }
}
