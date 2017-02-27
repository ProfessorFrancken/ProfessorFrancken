<?php

declare(strict_types=1);

namespace Francken\Domain\Posts\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;
use Francken\Domain\Posts\PostCategory;
use Francken\Domain\Posts\PostId;

final class PostCategorized implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $type;

    public function __construct(PostId $postId, PostCategory $type)
    {
        $this->postId = $postId;
        $this->type = $type;
    }

    public function postId() : PostId
    {
        return $this->postId;
    }

    public function type() : PostCategory
    {
        return $this->type;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'postId' => [PostId::class, 'deserialize']
        ];
    }
}
