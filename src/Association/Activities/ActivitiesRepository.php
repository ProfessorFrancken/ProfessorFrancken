<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Support\Collection;
use Carbon\Carbon;

final class ActivitiesRepository
{
    private $activities;

    public function __construct($calendar)
    {
        $this->activities = new Collection();
        $vcalendar = \Sabre\VObject\Reader::read(
            $calendar
        );

        foreach ($vcalendar->VEVENT as $event) {
            $this->activities[] = new CalendarEvent($event);
        }

        $this->activities = $this->activities->filter(function ($event) {
            return $event->status() === 'CONFIRMED';
        });
    }

    public function store(Activity $activity)
    {

    }

    public function all()
    {
        return $this->activities;
    }

    public function after(\DateTimeImmutable $after, int $amount = 5)
    {
        return $this->activities->filter(function ($activity) use ($after) {
            return $activity->endDate() > $after;
        })->sortBy(function ($event) {
            return $event->startDate();
        })->take($amount);
    }

    public function between(\DateTimeImmutable $after, \DateTimeImmutable $before)
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
                (int)$activity->endDate()->format('Y') === $year &&
                (int)$activity->endDate()->format('m') === $month
            );
        })->sortBy(function ($event) {
            return $event->startDate();
        });
    }
}
