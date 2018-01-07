<?php

declare(strict_types=1);

namespace Francken\Association\News\Eloquent;

use Carbon\Carbon;
use Francken\Association\News\Author;
use Francken\Association\News\CouldNotFindNews;
use Francken\Association\News\NewsItem;
use Francken\Association\News\Repository as NewsRepository;
use Illuminate\Database\Eloquent\Builder;
use League\Period\Period;

final class Repository implements NewsRepository
{
    private $showUnPublished = false;
    public function __construct(bool $showDrafts = false)
    {
        $this->showUnPublished = $showDrafts;

        News::addGlobalScope('published', function (Builder $builder) {
            if (! $this->showUnPublished) {
                $today = Carbon::today()->toDateString();
                $builder->whereNotNull('published_at')
                    ->whereDate('published_at', '<=', $today);

            }
        });
    }

    public function search(Period $period = null, string $subject = null, string $author = null) : array
    {
        return News::recent()
            ->inPeriod($period)
            ->withSubject($subject)
            ->withAuthorName($author)
            ->get()
            ->map(
                function (News $news) {
                    return $news->toNewsItem();
                }
            )
            ->toArray();
    }

    public function byLink(string $link) : NewsItem
    {
        $news = News::byLink($link)->first();

        if (is_null($news)) {
            throw CouldNotFindNews::forLink($link);
        }

        return $news->toNewsItem();
    }

    public function recent(int $amount) : array
    {
        return News::recent()
            ->take($amount)
            ->get()
            ->map(
                function (News $news) {
                    return $news->toNewsItem();
                }
            )
            ->toArray();
    }
}