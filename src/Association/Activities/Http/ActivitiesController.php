<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use DateTimeImmutable;
use Francken\Association\Activities\ActivitiesRepository;
use Illuminate\View\View;

final class ActivitiesController
{
    /**
     * @var string
     */
    public const CALENDAR_URL = 'https://calendar.google.com/calendar/ical/g8f50ild2kdf49bgathcdhvcqc%40group.calendar.google.com/public/basic.ics';

    private ActivitiesRepository $activities;

    public function __construct(ActivitiesRepository $activities)
    {
        $this->activities = $activities;
    }

    public function index() : View
    {
        $today = new DateTimeImmutable('now');

        return view('association.activities.index', [
            'activities' => $this->activities->after($today, 15),
            'searchTimeRange' => false,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => '/association/activities/', 'text' => 'Activities'],
            ],
        ]);
    }
}
