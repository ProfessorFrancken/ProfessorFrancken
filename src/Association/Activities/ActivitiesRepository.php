<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Support\Collection;
use Sabre\VObject\Component\VCalendar;
use Sabre\VObject\Reader;

final class ActivitiesRepository
{
    private Collection $activities;

    /**
     * @param resource $calendar opened ical file
     */
    public function __construct($calendar)
    {
        $this->activities = new Collection();
        /** @var VCalendar $vcalendar */
        $vcalendar = Reader::read(
            $calendar
        );

        foreach ($vcalendar->select('VEVENT') as $event) {
            $this->activities[] = CalendarEvent::fromEvent($event);
        }

        $this->activities = $this->activities->filter(fn ($event) : bool => $event->status() === 'CONFIRMED');
    }

    public function all() : Collection
    {
        return $this->activities;
    }
}
