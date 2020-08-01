<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use DateTimeImmutable;
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

        $this->activities = $this->activities->filter(function ($event) : bool {
            return $event->status() === 'CONFIRMED';
        });
    }

    public function all() : Collection
    {
        return $this->activities;
    }

    public function after(DateTimeImmutable $after, int $amount = 5) : Collection
    {
        return $this->activities->filter(function ($activity) use ($after) : bool {
            return $activity->endDate() > $after;
        })->sortBy(function ($event) {
            return $event->startDate();
        })->take($amount);
    }

    public function between(DateTimeImmutable $after, DateTimeImmutable $before) : Collection
    {
        return $this->activities->filter(function ($activity) use ($after, $before) : bool {
            return $activity->endDate() > $after && $activity->startDate() < $before;
        })->sortBy(function ($event) {
            return $event->startDate();
        });
    }

    public function inMonth(int $year, int $month) : Collection
    {
        return $this->activities->filter(function ($activity) use ($year, $month) : bool {
            return (
                (int)$activity->startDate()->format('Y') === $year &&
                (int)$activity->startDate()->format('m') === $month
            ) || (
                (int)$activity->endDate()->format('Y') === $year &&
                (int)$activity->endDate()->format('m') === $month
            );
        })->sortBy(function ($event) {
            return $event->startDate();
        });
    }
}
