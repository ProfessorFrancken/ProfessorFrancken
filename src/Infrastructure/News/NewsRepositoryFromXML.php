<?php

declare(strict_types=1);

namespace Francken\Infrastructure\News;

use DateTimeImmutable;
use Faker\Generator;
use Francken\Application\News\Author;
use Francken\Application\News\CompiledMarkdown;
use Francken\Application\News\NewsItem;
use Francken\Application\News\NewsItemLink;
use Francken\Application\News\NewsItemPreview;
use Francken\Application\News\NewsRepository;
use Francken\Domain\Boards\BoardRepository;
use Francken\Domain\News\NewsId;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\Image;
use League\HTMLToMarkdown\HtmlConverter;
use League\Period\Period;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;
use Webuni\CommonMark\TableExtension\TableExtension;

final class NewsRepositoryFromXml implements NewsRepository
{
    private $authors = [];

    private $items;

    private $markdown;

    public function __construct(string $filename)
    {
        $this->authors = config('francken.news.authors');
        $this->items = collect();
        $this->setupMarkdown();

        $loaded = simplexml_load_file($filename);
        $inner = $loaded->children()[0];

        $xml = simplexml_load_file($filename);
        $newsItems = $xml->xpath('/rss/channel/item');

        // Create NewsItemLink for previous and next
        $links = $this->linksFromXml($newsItems);

        // Create NewsItem
        $idx = 0;
        $previous = null;
        foreach ($newsItems as $newsItem) {
            $next = $links[$idx + 1] ?? null;
            $previous = $links[$idx - 1] ?? null;

            $idx++;

            $this->items[] = $this->importNewsItemFromXml($newsItem, $next, $previous);
        }

        $this->items = $this->items->unique(function (NewsItem $item) {
            return $item->content();
        })->unique(function (NewsItem $item) {
            return $item->title();
        })->filter();
    }

    public function recent(int $amount) : array
    {
        $env = Environment::createCommonMarkEnvironment();
        $env->addInlineRenderer(Image::class, new ResponsiveImageRenderer());
        $toHtml = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ], $env);

        return $this->items->reverse()->take($amount)
            ->map(function (NewsItem $item) use ($toHtml){
                $content = $toHtml->convertToHtml($item->content()->originalMarkdown());

                return new NewsItem(
                    $item->title(),
                    str_limit($content, 140),
                    $item->publicationDate(),
                    new Author($item->authorName(), $item->authorPhoto()),
                    CompiledMarkdown::fromSource($toHtml, $content),
                    [],
                    $item->previousNewsItem(),
                    $item->nextNewsItem()
                );
            })->toArray();
    }

    public function byLink(string $link) : NewsItem
    {
        $item = $this->items->filter(function (NewsItem $item) use ($link) {
            return $item->link() == $link;
        })->first();

        return $item;
    }

    public function inPeriod(Period $period) : array
    {
        $amount = NewsRepository::News_Items_Per_Archive_Page;

        return $this->items->reverse()->filter(function (NewsItem $item) use ($period) {
            $publishedAt = $item->publicationDate();

            return $period->contains($publishedAt);
        })->take($amount)->toArray();
    }

    public function search(Period $period = null, string $subject = null, string $author = null) : array
    {
        $amount = NewsRepository::News_Items_Per_Archive_Page;
        $items = $this->items->reverse();

        if (! is_null($period)) {
            $items = $items->filter(function (NewsItem $item) use ($period) {
                $publishedAt = $item->publicationDate();

                return $period->contains($publishedAt);
            });

        }

        if (! is_null($author) && $author != '') {
            $items = $items->filter(function (NewsItem $item) use ($author) {
                return str_contains($item->authorName(), $author);
            });
        }

        if (! is_null($subject) && $subject != '') {
            $items = $items->filter(function (NewsItem $item) use ($subject) {
                return str_contains($item->title(), $subject);
            });
        }

        return $items->take($amount)->toArray();
    }

    private function linksFromXml(array $newsItems) : array
    {
        $links = array_map(
            function ($item) {
                return $this->newsItemLinkFromXml($item);
            },
            $newsItems
        );

        return array_values(collect($links)->unique(function (NewsItemLink $item) {
            return $item->url();
        })->unique(function (NewsItemLink $item) {
            return $item->title();
        })->filter()->toArray());
    }

    private function newsItemLinkFromXml(\SimpleXMLElement $xml) : NewsItemLink
    {
        return new NewsItemLink(
            (string)$xml->title,
            new \DateTimeImmutable(
                (string)$xml->children('wp', true)->post_date
            )
        );
    }

    private function importNewsItemFromXml(\SimpleXMLElement $xml, NewsItemLink $next = null, NewsItemLink $previous = null) : NewsItem
    {
        $content = $this->loadContent($xml);

        $publicationDate = new \DateTimeImmutable(
            (string)$xml->children('wp', true)->post_date
        );

        $author = $this->importAuthorFromContent($content, $publicationDate);

        return new NewsItem(
            (string)$xml->title,
            str_limit($content, 140),
            $publicationDate,
            $author,
            CompiledMarkdown::fromSource($this->markdown, $content),
            [],
            $next,
            $previous
        );
    }

    private function loadContent(\SimpleXMLElement $xml)
    {
        $content = (string)$xml->children("content", true);

        // Some of the old legacy articles contain references to $hbar$ which was replaced with the following
        return preg_replace('$hbar$', '<span style="font-family\':serif;font-style:italic;">ħ</span>', $content);
    }

    private function importAuthorFromContent(string& $content, DateTimeImmutable $publicationDate) : Author
    {
        $authorKey = '';
        foreach ($this->authors as $author => $data) {
            if (preg_match($author, $content)) {
                $authorKey = $author;

                $content = str_replace($authorKey, '', $content);
                preg_match('/src="([^"]+)/i', $data['content'], $images);

                return new Author(
                    $data['name'],
                    image($images[1] ??  '/images/LOGO_KAAL.png', ['width' => '75', 'height' => '75'])
                );

                return [
                    'key' => $authorKey,
                    'name' => $data['name'],
                    'photo' => $images[1] ?? null,
                    'content' => $data['content'],
                ];
            }
        }

        $board = (new BoardRepository)->boardDuringDate($publicationDate);

        return Author::fromBoard($board);
    }

    private function setupMarkdown()
    {
        $env = Environment::createCommonMarkEnvironment();
        $env->addExtension(new TableExtension());
        $env->addExtension(new AttributesExtension());
        $env->addInlineRenderer(Image::class, new ResponsiveImageRenderer());

        $this->markdown = new CommonMarkConverter([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ], $env);
    }
}

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\ImageRenderer;

class ResponsiveImageRenderer extends ImageRenderer
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        $element = parent::render($inline, $htmlRenderer);

        $element->setAttribute('class', 'img-fluid');
        $element->setAttribute('src', news_image($element->getAttribute('src')));

        return $element;
    }
}
