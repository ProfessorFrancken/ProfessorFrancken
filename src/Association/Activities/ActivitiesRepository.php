<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Sabre\VObject\Reader;
use DateTimeImmutable;
use Illuminate\Support\Collection;

final class ActivitiesRepository
{
    private $activities;

    public function __construct($calendar)
    {
        $this->activities = new Collection();
        /** @var \Sabre\VObject\Component\VCalendar $vcalendar */
        $vcalendar = Reader::read(
            $calendar
        );

        foreach ($vcalendar->select('VEVENT') as $event) {
            $this->activities[] = new CalendarEvent($event);
        }

        $this->activities = $this->activities->filter(function ($event) {
            return $event->status() === 'CONFIRMED';
        });
    }

    public function all()
    {
        return $this->activities;
    }

    public function after(DateTimeImmutable $after, int $amount = 5)
    {
        return $this->activities->filter(function ($activity) use ($after) {
            return $activity->endDate() > $after;
        })->sortBy(function ($event) {
            return $event->startDate();
        })->take($amount);
    }

    public function between(DateTimeImmutable $after, DateTimeImmutable $before)
    {
        return $this->activities->filter(function ($activity) use ($after, $before) {
            return $activity->endDate() > $after && $activity->startDate() < $before;
        })->sortBy(function ($event) {
            return $event->startDate();
        });
    }

    public function inMonth(int $year, int $month)
    {
        return $this->activities->filter(function ($activity) use ($year, $month) {
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
