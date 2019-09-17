<?php

declare(strict_types=1);

namespace Francken\Domain\Posts\Events;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Posts\PostId;
use Francken\Domain\Serializable;

final class PostTitleChanged implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $title;

    public function __construct(PostId $postId, string $title)
    {
        $this->postId = $postId;
        $this->title = $title;
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
