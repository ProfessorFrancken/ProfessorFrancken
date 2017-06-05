<?php

declare(strict_types=1);

namespace Francken\Application\News;

final class PublishedNewsItem
{
    private $title;
    private $author;
    private $summary;
    private $published_at;

    /** @var CompiledMarkdown */
    private $contents;

    public function __construct(
        string $title,
        Author $author,
        string $summary,
        CompiledMarkdown $contents,
        DateTime $published_at
    ) {
        $this->title = $title;
        $this->author = $author;
        $this->summary = $summary;
        $this->contents = $contents;
        $this->published_at = $published_at;
    }

    public static function publish(
        NewsItem $item,
        MarkdownCompiler $compile
    ) : PublishedNewsItem {
        return new self(
            $item->title(),
            $item->author(),
            $item->summary(),
            $compile(
                $item->contents()
            ),
            $item->publishedAt()
        );
    }
}
