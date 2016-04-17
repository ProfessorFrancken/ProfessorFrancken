<?php

namespace Francken\Posts\Events;

use Francken\Posts\PostId;
use Francken\Base\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class PostCategorized implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $category;

    public function __construct(PostId $postId, string $category)
    {
        $this->postId = $postId;
        $this->category = $category;
    }

    public function postId() : PostId
    {
        return $this->postId;
    }

    public function category()
    {
        return $this->category;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'postId' => [PostId::class, 'deserialize']
        ];
    }
}
