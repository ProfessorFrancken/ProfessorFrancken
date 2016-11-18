<?php

declare(strict_types=1);

namespace Francken\Domain\Posts\Events;

use Carbon\Carbon;
use DateTimeImmutable;
use Francken\Domain\Posts\PostId;
use Francken\Domain\DomainEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

final class PostPublishedAt implements SerializableInterface
{
    use Serializable;

    private $postId;
    private $publishedAt;

    public function __construct(PostId $postId, Carbon $publishedAt)
    {
        $this->postId = $postId;
        $this->publishedAt = $publishedAt;
    }

    public function postId() : PostId
    {
        return $this->postId;
    }

    public function publishedAt() : DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            \DateTime::ISO8601,
            $this->publishedAt->format(\DateTime::ISO8601)
        );
    }

    protected static function deserializationCallbacks()
    {
        return [
            'postId' => [PostId::class, 'deserialize']
        ];
    }
}
