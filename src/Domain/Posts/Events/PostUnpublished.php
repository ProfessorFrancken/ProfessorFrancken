<?php

declare(strict_types=1);

namespace Francken\Domain\Posts\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;
use Francken\Domain\Posts\PostId;

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
