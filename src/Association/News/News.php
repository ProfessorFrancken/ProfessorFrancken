<?php

declare(strict_types=1);

namespace Francken\Association\News;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use League\Period\Period;

final class News extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'exerpt',
        'author_name',
        'author_photo',
        'source_contents',
        'compiled_contents',
        'published_at',
        'related_news_items',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'related_news_items' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function publish(DateTimeImmutable $publicationDate) : void
    {
        $this->published_at = $publicationDate;
        $this->slug = $publicationDate->format('y-m-d-') . Str::slug($this->title);
    }

    public function archive() : void
    {
        $this->published_at = null;
        $this->slug = $this->id . '-' . Str::slug($this->title);
    }

    public function changeAuthor(Author $author) : void
    {
        $this->author_name = $author->name();
        $this->author_photo = $author->photo();
    }

    public function changeTitle(string $title) : void
    {
        $this->title = $title;

        if ($this->published_at !== null) {
            $this->slug = $this->published_at->format('y-m-d-') . Str::slug($this->title);
        } else {
            $this->slug = $this->id . '-' . Str::slug($this->title);
        }
    }

    public function changeContents(CompiledMarkdown $markdown) : void
    {
        $this->source_contents = $markdown->originalMarkdown();
        $this->compiled_contents = (string)$markdown;
    }

    public function changeExerpt(string $exerpt) : void
    {
        $this->exerpt = $exerpt;
    }

    /**
     * Scope a query to only include news with the given slug
     */
    public function scopeByLink(Builder $query, string $slug) : Builder
    {
        return $query->whereSlug($slug);
    }

    /**
     * Scope a query to only include news only news before the current news
     */
    public function previous() : ?self
    {
        if ($this->published_at === null) {
            return null;
        }

        /** @var News|null */
        return self::orderBy('published_at', 'desc')
            ->where('id', '<>', $this->id)
            ->whereDate('published_at', '<=', $this->published_at->toDateTimeString())
            ->first();
    }

    /**
     * Scope a query to only include news only news before the current news
     */
    public function next() : ?self
    {
        if ($this->published_at === null) {
            return null;
        }

        /** @var News|null */
        return self::orderBy('published_at', 'asc')
            ->where('id', '<>', $this->id)
            ->whereDate('published_at', '>=', $this->published_at->toDateTimeString())
            ->first();
    }

    /**
     * Sort the query by most recent news
     */
    public function scopeRecent(Builder $query) : Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Scope a query to only include news published in a given period
     *
     * @param Period $period
     */
    public function scopeInPeriod(Builder $query, Period $period = null) : Builder
    {
        return (isset($period) ? $query->whereBetween('published_at', [$period->getStartDate(), $period->getEndDate()]) : $query);
    }


    /**
     * Scope a query to only include news with a whose subject includes
     * the given subject string
     */
    public function scopeWithSubject(Builder $query, string $subject = null) : Builder
    {
        return (isset($subject) ? $query->whereTitle($subject) : $query);
    }

    /**
     * Scope a query to only include a given author
     *
     * @param string $author
     */
    public function scopeWithAuthorName(Builder $query, string $author = null) : Builder
    {
        return (isset($author) ? $query->whereAuthorName($author) : $query);
    }

    private function contents() : CompiledMarkdown
    {
        return CompiledMarkdown::withSource(
            $this->compiled_contents ?? '',
            $this->source_contents ?? ''
        );
    }

    private function author() : Author
    {
        return new Author(
            $this->author_name,
            $this->author_photo
        );
    }
}
