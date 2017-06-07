<?php

declare(strict_types=1);

namespace Francken\Application\News;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use DateTimeImmutable;

final class NewsItem
{
    private $title;
    private $exerpt;
    private $publicationDate;
    private $authorName;
    private $content;
    private $related;
    private $next;
    private $previous;

    public function __construct(
        string $title,
        string $exerpt,
        DateTimeImmutable $publicationDate,
        string $authorName,
        string $content,
        array $related = [],
        NewsItemLink $previous,
        NewsItemLink $next = null
    ) {
        $this->title = $title;
        $this->exerpt = $exerpt;
        $this->publicationDate = $publicationDate;
        $this->authorName = $authorName;
        $this->content = $content;
        $this->related = (function(NewsItemLink ...$item) {
            return $item;
        })(...$related);
        $this->next = $next;
        $this->previous = $previous;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function url() : string
    {
        return '/association/news/' . str_slug($this->title());
    }

    public function exerpt() : string
    {
        return $this->exerpt;
    }

    public function publicationDate() : DateTimeImmutable
    {
        return $this->publicationDate;
    }

    public function authorName() : string
    {
        return $this->authorName;
    }

    public function content() : string
    {
        return $this->content;
    }

    public function relatedNewsItems() : array
    {
        return $this->related;
    }

    public function nextNewsItem() : NewsItemLink
    {
        return $this->next;
    }

    public function previousNewsItem() : NewsItemLink
    {
        return $this->next;
    }
}
