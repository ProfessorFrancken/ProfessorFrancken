<?php

declare(strict_types=1);

namespace Francken\Application\ReadModel\PostList;

use Broadway\ReadModel\Identifiable as ReadModelInterface;
use Broadway\Serializer\Serializable as SerializableInterface;
use DateTimeImmutable;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Posts\PostId;
use Francken\Domain\Serializable;

final class PostList implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $authorId;
    private $title;
    private $content;
    private $type;
    private $publishedAt;

    public function __construct(
        PostId $id,
        MemberId $authorId,
        string $title,
        string $content,
        $type,
        DateTimeImmutable $publishedAt
    ) {
        $this->id = (string)$id;
        $this->authorId = (string)$authorId;
        $this->title = $title;
        $this->content = $content;
        $this->type = $type;
        $this->publishedAt = $publishedAt->format(\DateTime::ISO8601);
    }

    public function id() : PostId
    {
        return new PostId($this->id);
    }

    public function authorId() : MemberId
    {
        return new MemberId($this->authorId);
    }

    public function title() : string
    {
        return $this->title;
    }

    public function content() : string
    {
        return $this->content;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function publishedAt() : DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            \DateTime::ISO8601,
            $this->publishedAt
        );
    }

    public function getId() : string
    {
        return $this->id;
    }
}
