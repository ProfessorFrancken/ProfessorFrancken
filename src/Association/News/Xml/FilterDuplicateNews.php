<?php

declare(strict_types=1);

namespace Francken\Association\News\Xml;

use Francken\Domain\Boards\BoardRepository;
use Francken\Association\News\Repository;
use Francken\Association\News\Eloquent\News;
use Francken\Association\News\NewsItem;
use FilterIterator;
use Iterator;

/**
 * Since our old wordpress website contains both Dutch and English news items
 * we will filter all duplicates here
 */
final class FilterDuplicateNews extends FilterIterator
{
    private $news;

    public function __construct(Iterator $iterator)
    {
        parent::__construct($iterator);

        // Keep track of all news items that we've accepted
        $this->news = collect();
    }

    public function accept()
    {
        $news = $this->getInnerIterator()->current();

        if ($this->contains($news)) {
            return false;
        }

        $this->news[] = $news;

        return true;
    }

    private function contains(NewsItem $news) : bool
    {
        $title = $news->title();
        $content = (string)$news->content();

        return $this->containsTitle($title) ||
            $this->containsContent($content);
    }

    private function containsTitle(string $title) : bool
    {
        return $this->news->contains(function ($news) use ($title) {
            return $news->title() == $title;
        });
    }

    private function containsContent(string $content) : bool
    {
        return $this->news->contains(function ($news) use ($content) {
            return (string)$news->content() == $content;
        });
    }
}
