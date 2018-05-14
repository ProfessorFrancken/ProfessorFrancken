<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\Activities\ActivitiesSidebarComposer;

class ActivitiesFeature extends TestCase
{
    /** @setup */
    public function setup_activities_repository()
    {
        $this->app->bind(
            ActivitiesRepository::class,
            function ($app) {
                $data = <<<CALENDAR
BEGIN:VCALENDAR
BEGIN:VEVENT
DTSTART:20180516T100000Z
DTEND:20180516T110000Z
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
CALENDAR;
                return new ActivitiesRepository(
                    $data
                );
            }
        );
    }

    /** @test */
    public function it_shows_upcoming_activities()
    {
        $this->visit('/association/activities')
             ->see("Lunch lecture: Demcon");
    }

    /** @test */
    public function it_shows_activities_in_a_given_month()
    {
        $this->visit('/association/activities/2018/5')
             ->see("Lunch lecture: Demcon");
    }

    /** @test */
    public function if_no_activities_are_planned_it_shows_nothing()
    {
        $this->visit('/association/activities/2019/5')
             ->dontSee("Lunch lecture: Demcon");
    }
}

