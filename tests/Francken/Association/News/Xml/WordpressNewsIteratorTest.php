<?php

declare(strict_types=1);

namespace Francken\Tests\Association\News\Xml;

use Francken\Association\News\Xml\WordpressNewsIterator;
use Francken\Domain\Boards\BoardRepository;
use Francken\Features\TestCase;

final class WordpressNewsIteratorTest extends TestCase
{
    /** @test */
    function it_imports_news_from_an_xml_file()
    {
        $filename = __DIR__ . "/example.xml";
        $authors = config('francken.news.authors');
        $boards = new BoardRepository;

        $iterator = new WordpressNewsIterator($filename, $authors, $boards);

        $news = array_map(function ($item) {
            return $item;
        }, iterator_to_array($iterator));

        $latestNews = $news[count($news) - 1];

        $this->assertTrue($latestNews->authorName() === 'Steven Groen');
        $this->assertFalse(
            str_contains(
                (string)$latestNews->content(),
                ':blog-steven:'
            )
        );

        $this->assertFalse(
            str_contains(
                (string)$latestNews->exerpt(),
                ':blog-steven:'
            )
        );
    }
}
