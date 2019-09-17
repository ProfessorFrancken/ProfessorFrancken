<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Xml;

use Francken\Association\News\Author;
use Francken\Association\News\CompiledMarkdown;
use Francken\Association\News\NewsItem;
use Francken\Association\News\Xml\FilterDuplicateNews;
use PHPUnit\Framework\TestCase as TestCase;

final class FilterDuplicateNewsTest extends TestCase
{
    /** @test */
    public function it_no_news_items_if_no_duplicates_exists() : void
    {
        $source = [
            $this->aNewsItem('title 1', 'content 1'),
            $this->aNewsItem('title 2', 'content 2'),
            $this->aNewsItem('title 3', 'content 3'),
        ];
        $filter = new FilterDuplicateNews(new \ArrayIterator($source));

        $this->assertEquals(
            $source,
            iterator_to_array($filter)
        );
    }

    /** @test */
    public function it_filters_news_items_based_on_title() : void
    {
        $source = [
            $this->aNewsItem('title'),
            $this->aNewsItem('title')
        ];
        $filter = new FilterDuplicateNews(new \ArrayIterator($source));

        $this->assertEquals(
            [$this->aNewsItem('title')],
            iterator_to_array($filter)
        );
    }

    /** @test */
    public function it_filters_news_items_based_on_their_content() : void
    {
        $source = [
            $this->aNewsItem('title 1', 'content'),
            $this->aNewsItem('title 2', 'content')
        ];
        $filter = new FilterDuplicateNews(new \ArrayIterator($source));

        $this->assertEquals(
            [$this->aNewsItem('title 1', 'content')],
            iterator_to_array($filter)
        );
    }


    private function aNewsItem($title = '', $content = '') : NewsItem
    {
        $author = new Author('Mark', '');
        $content = CompiledMarkdown::withSource(
            $content, $content
        );
        return new NewsItem(
            $title,
            'exerpt',
            $author,
            $content,
            new \DateTimeImmutable('2018-01-02')
        );
    }
}
