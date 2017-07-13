<?php

declare(strict_types=1);

namespace Francken\Application\News;

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

    public function title() : string
    {
        return $this->title;
    }

    private function link() : string
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
