<?php

declare(strict_types=1);

namespace Francken\Association\News\Eloquent;

use DateTimeImmutable;
use Francken\Association\News\Author;
use Francken\Association\News\CompiledMarkdown;
use Francken\Association\News\NewsItem;
use Francken\Association\News\NewsItemLink;
use Illuminate\Database\Eloquent\Model as Eloquent;
use League\Period\Period;

final class News extends Eloquent
{
    protected $fillable = [
        'title',
        'exerpt',
        'author_name',
        'author_photo',
        'source_contents',
        'compiled_contents',
        'related_news_items',
    ];

    protected $casts = [
        'related_news_items' => 'array',
    ];


    // waarschijnlijk gaat er wat mis bij het converteren van string naar object oid

    protected $dates = [
        'created_at',
        'updated_at',
        'published_at'
    ];

    public function publish(DateTimeImmutable $publicationDate)
    {
        $this->published_at = $publicationDate;
        $this->slug = $this->toNewsItem()->link();
    }

    public function archive()
    {
        $this->published_at = null;
        $this->slug = $this->toNewsItem()->link();
    }

    public function changeAuthor(Author $author)
    {
        $this->author_name = $author->name();
        $this->author_photo = $author->photo();
    }

    public function changeTitle(string $title)
    {
        $this->title = $title;
        $this->slug = $this->toNewsItem()->link();
    }

    public function changeContents(CompiledMarkdown $markdown)
    {
        $this->source_contents = $markdown->originalMarkdown();
        $this->compiled_contents = (string)$markdown;
    }

    public function changeExerpt(string $exerpt)
    {
        $this->exerpt = $exerpt;
    }

    private function contents() : CompiledMarkdown
    {
        return CompiledMarkdown::withSource(
            $this->compiled_contents,
            $this->source_contents
        );
    }

    private function author() : Author
    {
        return new Author(
            $this->author_name,
            $this->author_photo
        );
    }

    /**
     * This method is used by the Repository class so that we can
     * use a plain old php object (the NewsItem) instead of an
     * Eloquent object inside of our views
     */
    public function toNewsItem() : NewsItem
    {
        return new NewsItem(
            $this->title,
            $this->exerpt,
            new DateTimeImmutable((string) $this->published_at),
            $this->author(),
            $this->contents(),
            [],   // related
            $this->previousNewsLink(),
            $this->nextNewsLink()
        );
    }

    private function previousNewsLink() : ?NewsItemLink
    {
        $previous = $this->previous();

        if ($previous === null) {
            return null;
        }

        return new NewsItemLink(
            $previous->title,
            new DateTimeImmutable((string) $previous->published_at)
        );
    }

    private function nextNewsLink() : ?NewsItemLink
    {
        $next = $this->next();

        if ($next === null) {
            return null;
        }

        return new NewsItemLink(
            $next->title,
            new DateTimeImmutable((string) $next->published_at)
        );
    }

    public static function fromNewsItem(NewsItem $news) : self
    {
        $content = $news->content();

        $item = new self([
            'title' => $news->title(),
            'exerpt' => $news->exerpt(),
            'author_name' => $news->authorName(),
            'author_photo' => $news->authorPhoto(),
            'source_contents' => $content->originalMarkdown(),
            'compiled_contents' => (string)$content,
            'related_news_items' => collect(
                $news->relatedNewsItems()
            )->map(function ($news) { return (string)$news->id(); }),
        ]);

        $item->published_at = $news->publicationDate();
        $item->slug = $news->link();

        return $item;
    }


    // To published news item


    // Specific eloquent stuff

    /**
     * Scope a query to only include news with the given slug
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLink($query, string $slug)
    {
        return $query->whereSlug($slug);
    }

    /**
     * Scope a query to only include news only news before the current news
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function previous()
    {
        if ($this->published_at === null) {
            return null;
        }

        return News::orderBy('published_at', 'desc')
            ->where('id', '<>', $this->id)
            ->whereDate('published_at', '<=', $this->published_at->toDateTimeString())
            ->first();
    }

    /**
     * Scope a query to only include news only news before the current news
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function next()
    {
        if ($this->published_at === null) {
            return null;
        }

        return News::orderBy('published_at', 'asc')
            ->where('id', '<>', $this->id)
            ->whereDate('published_at', '>=', $this->published_at->toDateTimeString())
            ->first();
    }

    /**
     * Sort the query by most recent news
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to only include news published in a given period
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \League\Period\Period $period
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInPeriod($query, Period $period = null)
    {
        return (isset($period) ? $query->whereBetween('published_at', [$period->getStartDate(), $period->getEndDate()]) : $query);
    }


    /**
     * Scope a query to only include news with a whose subject includes
     * the given subject string
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithSubject($query, string $subject = null)
    {
        return (isset($subject) ? $query->whereTitle($subject) : $query);
    }

    /**
     * Scope a query to only include a given author
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Francken\Association\News\Author $author
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAuthorName($query, string $author = null)
    {
        return (isset($author) ? $query->whereAuthorName($author) : $query);
    }
}