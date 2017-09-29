<?php

declare(strict_types=1);

namespace Francken\Application\News;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use DateTimeImmutable;
use Francken\Domain\Url;

final class NewsItemId {
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString() : string
    {
        return $this->id;
    }
}

final class NewsItem
{
    private $id = 1;
    private $title;
    private $exerpt;
    private $publicationDate;
    private $author;
    private $content;
    private $related;
    private $next;
    private $previous;

    public function __construct(
        string $title,
        string $exerpt,
        DateTimeImmutable $publicationDate,
        Author $author,
        CompiledMarkdown $content,
        array $related = [],
        NewsItemLink $previous = null,
        NewsItemLink $next = null
    ) {
        $this->id = '1';
        $this->title = $title;
        $this->exerpt = $exerpt;
        $this->publicationDate = $publicationDate;
        $this->author = $author;
        $this->content = $content;
        $this->related = (function(NewsItemLink ...$item) {
            return $item;
        })(...$related);
        $this->next = $next;
        $this->previous = $previous;
    }

    public function id() : NewsItemId
    {
        return new NewsItemId(
            // $this->id
            $this->link()
        );
    }

    public function title() : string
    {
        return $this->title;
    }

    public function link() : string
    {
        return $this->publicationDate()->format('y-m-d-') . str_slug($this->title());
    }

    public function url() : string
    {
        return '/association/news/' . $this->link();
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
        return $this->author->name();
    }

    public function authorPhoto() : string
    {
        return $this->author->photo();
    }

    public function content() : CompiledMarkdown
    {
        return $this->content;
    }

    public function relatedNewsItems() : array
    {
        return $this->related;
    }

    public function nextNewsItem() : ?NewsItemLink
    {
        return $this->next;
    }

    public function previousNewsItem() : ?NewsItemLink
    {
        return $this->previous;
    }
}
