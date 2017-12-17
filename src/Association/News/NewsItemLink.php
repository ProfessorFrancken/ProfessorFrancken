<?php

declare(strict_types=1);

namespace Francken\Association\News;

use DateTimeImmutable;

final class NewsItemLink
{
    private $title;
    private $publicationDate;
    private $url;

    public function __construct(
        string $title,
        DateTimeImmutable $publicationDate = null
    ) {
        $this->title = $title;
        $this->publicationDate = $publicationDate;

        $this->url = '/association/news/' . $this->link();
    }

    public function id() : string
    {
        return '1';
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
        return $this->url;
    }

    public function publicationDate() : DateTimeImmutable
    {
        return $this->publicationDate;
    }
}

