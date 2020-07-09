<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

// use Illuminate\Http\Response;

final class IcalController
{
    /**
     * @var string
     */
    public const CALENDAR_URL = 'https://calendar.google.com/calendar/ical/g8f50ild2kdf49bgathcdhvcqc%40group.calendar.google.com/public/basic.ics';

    public function index() : View
    {
        return view('association.activities.ical', [
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => '/association/activities/', 'text' => 'Activities'],
                ['url' => '/association/activities/ical', 'text' => 'Synchronize our calendar'],
            ],
            'selectedMonth' => 0,
            'searchTimeRange' => false,
            'calendarUrl' => action([static::class, 'show']),
        ]);
    }

    /**
     * This is currently a simple wrapper arround the ical from Google calendar,
     * however later we will replace this with a custom ical
     */
    public function show() : Response
    {
        $url = static::CALENDAR_URL;
        $file = file_get_contents($url);

        return new Response(
            $file,
            200,
            [
                'Content-Type' => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="cal.ics"',
            ]
        );
    }
}
