<?php

declare(strict_types=1);

namespace Francken\Application\News;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use DateTimeImmutable;

final class NewsItemPreview
{
    private $title;
    private $publicationDate;
    private $url;
    private $exerpt;
    private $authorName;

    public function __construct(
        string $title,
        string $exerpt,
        DateTimeImmutable $publicationDate,
        string $authorName
    ) {
        $this->title = $title;
        $this->publicationDate = $publicationDate;
        $this->url = '/association/news/' . $this->link();
        $this->exerpt = $exerpt;
        $this->authorName = $authorName;
    }

    private function link() : string
    {
        return $this->publicationDate()->format('y-m-d-') . str_slug($this->title());
    }

    public function title() : string
    {
        return $this->title;
    }

    public function url() : string
    {
        return $this->url;
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
}
