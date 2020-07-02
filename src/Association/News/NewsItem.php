<?php

declare(strict_types=1);

namespace Francken\Association\News;

use DateTimeImmutable;
use Francken\Association\News\Http\NewsController;

final class NewsItemId
{
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

    public function __construct(
        string $title,
        string $exerpt,
        Author $author,
        CompiledMarkdown $content,
        DateTimeImmutable $publicationDate = null,
        array $related = []
    ) {
        $this->id = '1';
        $this->title = $title;
        $this->exerpt = $exerpt;
        $this->publicationDate = $publicationDate;
        $this->author = $author;
        $this->content = $content;
        $this->related = $related;
    }

    public static function empty()
    {
        return new self(
            '',
            '',
            new Author('', ''),
            CompiledMarkdown::withSource('', '')
        );
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
        if ($this->publicationDate !== null) {
            return $this->publicationDate()->format('y-m-d-') . str_slug($this->title());
        }

        return str_slug($this->title());
    }

    public function url() : string
    {
        return action([NewsController::class, 'show'], ['news' => $this]);
    }

    public function exerpt() : string
    {
        return $this->exerpt;
    }

    public function publicationDate() : ?DateTimeImmutable
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
        return [];
    }
}
