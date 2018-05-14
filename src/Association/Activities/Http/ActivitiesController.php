<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use DateInterval;
use DateTimeImmutable;
use League\Period\Period;
use Francken\Association\Activities\ActivitiesRepository;

final class ActivitiesController
{
    private $activities;

    public function __construct(ActivitiesRepository $activities)
    {
        $this->activities = $activities;
    }

    public function index()
    {
        $today = new \DateTimeImmutable('now');

        return view('association.activities.index')
            ->with('activities', $this->activities->after($today, 15))
            ->with('searchTimeRange', false);
    }

    public function show($activity)
    {
        $newsItem = $this->news->byLink($link);

        return view('pages.association.news.item')
            ->with('newsItem', $newsItem);
    }
}
