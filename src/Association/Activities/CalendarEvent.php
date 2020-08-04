<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use DateTimeImmutable;
use DateTimeZone;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Sabre\VObject\Component\VEvent;

final class CalendarEvent
{
    public string $id;

    public Collection $notes;
    private string $uid;
    private string $recurrence;
    private string $summary;

    private string $description;

    private string $location;

    private DateTimeImmutable $start;

    private DateTimeImmutable $end;

    private string $status;

    public function __toString() : string
    {
        return $this->id;
    }

    public static function fromEvent(VEvent $event) : self
    {
        $calendarEvent = new self();
        $calendarEvent->id = (string)Arr::first($event->select('UID'));
        $calendarEvent->uid = $calendarEvent->id;
        $calendarEvent->recurrence = ((string)Arr::first($event->select('RECURRENCE-ID')));
        $calendarEvent->summary = (string)Arr::first($event->select('SUMMARY'));
        $calendarEvent->description = (string)Arr::first($event->select('DESCRIPTION'));
        $calendarEvent->location = (string)Arr::first($event->select('LOCATION'));
        $calendarEvent->status = (string)Arr::first($event->select('STATUS'));
        $calendarEvent->notes = collect();
        $calendarEvent->parseSchedule($event);
        return $calendarEvent;
    }
    public function uid() : string
    {
        if ($this->recurrence !== '') {
            return $this->uid . '_' . $this->recurrence;
        }
        return $this->uid;
    }

    public function startDate() : DateTimeImmutable
    {
        return $this->start->setTimeZone(new DateTimeZone('Europe/Amsterdam'));
    }

    public function endDate() : DateTimeImmutable
    {
        return $this->end->setTimeZone(new DateTimeZone('Europe/Amsterdam'));
    }

    public function status() : string
    {
        return $this->status;
    }

    public function name() : string
    {
        return $this->summary;
    }

    public function description() : string
    {
        return $this->description;
    }

    public function location() : string
    {
        if ($this->location == "Technisch Fysische Vereniging 'Professor Francken', Nijenborgh 4, 9747 AG Groningen, Netherlands") {
            return 'Franckenroom';
        }

        return $this->location;
    }

    public function shortDescription() : string
    {
        return Str::limit($this->description, 150);
    }

    private function parseSchedule(VEvent $event) : void
    {
        $this->start = Arr::first($event->select('DTSTART'))->getDateTime();
        $this->end = Arr::first($event->select('DTEND'))->getDateTime();
    }
}
