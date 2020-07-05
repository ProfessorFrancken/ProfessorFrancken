<?php

declare(strict_types=1);

namespace Francken\Features;

use DateTimeImmutable;
use DateInterval;
use Francken\Association\Activities\ActivitiesRepository;

class ActivitiesFeature extends TestCase
{
    private DateTimeImmutable $start;

    public function setUp() : void
    {
        parent::setUp();

        $tomorrow = new DateTimeImmutable('tomorrow +1day');
        $this->start = $tomorrow;
        $start = $tomorrow->format('Ymd');
        $end = $tomorrow->format('Ymd');

        $this->app->bind(
            ActivitiesRepository::class,
            function ($app) use ($start, $end) {
                $data = <<<CALENDAR
BEGIN:VCALENDAR
BEGIN:VEVENT
DTSTART:{$start}
DTEND:{$end}
DTSTAMP:20180503T094905Z
UID:1id4gr64bsncqjk5dgbnodecoo@google.com
ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;CN=Activi
 teitenkalender T.F.V. 'Professor Francken';X-NUM-GUESTS=0:mailto:g8f50ild2k
 df49bgathcdhvcqc@group.calendar.google.com
CREATED:20180411T143903Z
DESCRIPTION:
LAST-MODIFIED:20180430T132554Z
LOCATION:5113.0202
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:Lunch lecture: Demcon
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR
CALENDAR;
                return new ActivitiesRepository(
                    $data
                );
            }
        );
    }

    /** @test */
    public function it_shows_upcoming_activities() : void
    {
        $this->visit('/association/activities')
             ->see("Lunch lecture: Demcon");
    }

    /** @test */
    public function it_shows_activities_in_a_given_month() : void
    {
        $this->visit('/association/activities/' . $this->start->format('Y/m'))
             ->see("Lunch lecture: Demcon");
    }

    /** @test */
    public function if_no_activities_are_planned_it_shows_nothing() : void
    {
        $this->visit('/association/activities/' . $this->start->add(new DateInterval('P1Y'))->format('Y/m'))
             ->dontSee("Lunch lecture: Demcon");
    }
}
