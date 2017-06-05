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
        NewsItemLink $next,
        NewsItemLink $previous
    ) {
        $this->title = $title;
        $this->exerpt = $exerpt;
        $this->publicationDate = $publicationDate;
        $this->authorName = $authorName;
        $this->content = $content;
        $this->related = $related;
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

// final class NewsItem //implements ReadModelInterface, SerializableInterface
// {
//     private $title;
//     private $summary;
//     private $contents;
//     private $author;
//     private $published_at;

//     public function __construct(
//         string $title,
//         string $summary,
//         string $contents,
//         Author $author
//     ) {
//         $this->title = $title;
//         $this->summary = $summary;
//         $this->contents = $contents;
//         $this->author = $author;
//     }

//     public function publish(MarkdownCompiler $compiler, DateTime $at) : PublishedNewsItem
//     {
//         $this->published_at = $at;

//         $this->raise(
//             new NewsItemWasPublished($this->id, $at)
//         );
//         return PublishedNewsItem::publish($this, $compiler);
//     }

//     public function changeAuthor(Author $author)
//     {
//         $this->author = $author;

//         $this->raise(
//             new AuthorWasChanged($this->id, $author)
//         );
//     }

//     public function title() : string
//     {
//         return $this->title;
//     }

//     public function contents() : string
//     {
//         return $this->contents;
//     }

//     public function summary() : string
//     {
//         return $this->summary;
//     }

//     public function author() : Author
//     {
//         return $this->author;
//     }

//     public function publishedAt()
//     {
//         return 'never';
//     }
// }
