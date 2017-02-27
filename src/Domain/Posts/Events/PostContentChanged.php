<?php

declare(strict_types=1);

namespace Francken\Domain\Posts\Events;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;
use Francken\Domain\Posts\PostId;

final class PostContentChanged implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $content;

    public function __construct(PostId $postId, string $content)
    {
        $this->postId = $postId;
        $this->content = $content;
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
