<?php

declare(strict_types=1);

namespace Francken\Association\News\Xml;

use DateTimeImmutable;
use Francken\Association\Boards\Board;
use Francken\Association\News\Author;
use Francken\Association\News\NewsContentCompiler;
use Francken\Association\News\NewsItem;
use SimpleXMLIterator;

final class WordpressNewsIterator implements \IteratorAggregate
{
    private $authors;
    private $filename;
    private $compiler;

    public function __construct(string $filename, array $authors)
    {
        $this->authors = $authors;
        $this->compiler = new NewsContentCompiler();
        $this->filename = $filename;
    }

    public function getIterator()
    {
        $xml = new SimpleXMLIterator($this->filename, 0, true);

        return new MapIterator(
            new \ArrayIterator($xml->xpath('/rss/channel/item')),
            function ($news) {
                return $this->toNewsItem($this->parseNews($news));
            }
        );
    }

    private function toNewsItem($news)
    {
        return new NewsItem(
            $news['title'],
            (string)$news['content']->exerpt(),
            $news['author'],
            $news['content']->content(),
            $news['published_at'],
            []
        );
    }

    private function parseNews($news)
    {
        $wordpress = $news->children('wp', true);
        $publicationDate = new \DateTimeImmutable((string)$wordpress->post_date);
        $content = (string)$news->children('content', true);
        $compiler = $this->compiler;

        return [
            'title' => (string)$news->title,
            'published_at' => $publicationDate,
            'content' => new NewsContent(
                $this->compiler,
                $this->authors,
                $content
            ),
            'author' => $this->importAuthor(
                $this->authors,
                $content,
                $publicationDate
            )
        ];
    }

    private function importAuthor(array $authors, string $content, DateTimeImmutable $publicationDate) : Author
    {
        foreach ($authors as $author => $data) {
            if ( ! preg_match($author, $content)) {
                continue;
            }

            return new Author(
                $data['name'],
                // Use our image service to get a resized picture
                image(
                    $data['image'] ??  '/images/LOGO_KAAL.png',
                    ['width' => '75', 'height' => '75']
                )
            );
        }

        // Assume that one of the board members has written this news
        $board = Board::orderBy('installed_at', 'desc')
            ->where('installed_at', '<=', $publicationDate)
            ->where(function ($query) use ($publicationDate) {
                return $query->where('demissioned_at', '>=', $publicationDate)
                    ->orWhere('demissioned_at', '=', null);
            })
            ->first();

        return ($board) ? Author::fromBoard($board) : new Author('Unkown');
    }
}

class NewsContent
{
    private $content;
    private $compiler;

    public function __construct(NewsContentCompiler $compiler, array $authors, string $content)
    {
        $this->compiler = $compiler;

        // Some of the old legacy articles contain references to $hbar$ which was replaced with the following
        $content = preg_replace(
            '$hbar$',
            '<span style="font-family\':serif;font-style:italic;">ħ</span>',
            $content
        );

        // Remove keys used to indicate what the author of news was
        foreach ($authors as $author => $data) {
            $content = str_replace($author, '', $content);
        }

        $this->content = $content;
    }

    public function content()
    {
        return $this->compiler->content($this->content);
    }

    public function exerpt()
    {
        return $this->compiler->exerpt(str_limit($this->content, 140));
    }
}

/* From https://github.com/guzzle/iterator/blob/master/MapIterator.php */
class MapIterator extends \IteratorIterator
{
    /** @var mixed Callback */
    protected $callback;
    /**
     * @param \Traversable   $iterator Traversable iterator
     * @param array|\Closure $callback Callback used for iterating
     *
     * @throws InvalidArgumentException if the callback if not callable
     */
    public function __construct(\Traversable $iterator, $callback)
    {
        parent::__construct($iterator);
        if ( ! is_callable($callback)) {
            throw new InvalidArgumentException('The callback must be callable');
        }
        $this->callback = $callback;
    }
    public function current()
    {
        return call_user_func($this->callback, parent::current());
    }
}
