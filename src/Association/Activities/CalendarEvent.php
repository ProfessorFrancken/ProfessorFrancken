<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Carbon\Carbon;
use DateTimeImmutable;
use DateTimeZone;
use Sabre\VObject\Component\VEvent;

final class CalendarEvent
{
    private $summary;
    private $description;
    private $location;
    private $start;
    private $end;
    private $status;
    private $google_id;
    private $last_modified_at_google;
    private $event;

    public function __construct(VEvent $event)
    {
        $this->event = $event;

        $this->summary = (string)$event->SUMMARY;
        $this->description = (string)$event->DESCRIPTION;
        $this->location = (string)$event->LOCATION;
        $this->status = (string)$event->STATUS;
        $this->google_id = (string)$event->UID;
        $this->last_modified_at_google = array_first(
            $event->select('LAST-MODIFIED')
        )->getDateTime();

        $this->parseSchedule($event);
    }

    public function startDate() : DateTimeImmutable
    {
        return $this->start;
    }

    public function endDate() : DateTimeImmutable
    {
        return $this->end;
    }

    public function status() : string
    {
        return $this->status;
    }

    public function title() : string
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
        return str_limit($this->description, 150);
    }

    public function url() : string
    {
        return '';
    }

    /*
     * [day] [mnth] to [day] [mnth]
     * Shows first month only when it is different
     */
    public function schedule()
    {
        $string = '';
        $from = Carbon::createFromFormat('Y-m-d', $this->startDate()->format('Y-m-d'));
        $to = Carbon::createFromFormat('Y-m-d', $this->endDate()->format('Y-m-d'));

        $start = $this->startDate()->setTimeZone(new DateTimeZone('Europe/Amsterdam'));
        $end = $this->endDate()->setTimeZone(new DateTimeZone('Europe/Amsterdam'));

        $string .= $start->format('d');

        // Display month and year only twice if necessary
        if ($from->month != $to->month) {
            $string .= $start->format(' F');
        }

        // Check if the end date is different
        if ($from->format('Y-m-d') != $to->format('Y-m-d')) {
            $string .= ' - ' . $end->format('d F');
        } else {
            $string .= $end->format(' F');
        }

        // Show time if the activity isn't on the whole day
        if ($this->startDate()->format('H:i') !== '00:00') {
            $string .= ' at ' . $start->format('H:i');
        }

        return $string;
    }


    private function parseSchedule($event) : void
    {
        $this->start = $event->DTSTART->getDateTime();
        $this->end = $event->DTEND->getDateTime();
    }
}
