<?php

declare(strict_types=1);

namespace Francken\Domain\Posts\Events;

use Francken\Domain\Posts\PostId;
use Francken\Domain\DomainEvent;
use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Serializable;

final class DraftDeleted implements SerializableInterface
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
