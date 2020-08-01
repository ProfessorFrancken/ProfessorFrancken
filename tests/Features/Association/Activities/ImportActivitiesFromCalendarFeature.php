<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use Francken\Association\Activities\ActivitiesRepository;
use Francken\Association\Activities\Activity;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class ImportActivitiesFromCalendarFeature extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_imports_activities_from_calendar() : void
    {
        $existingActivity = factory(Activity::class)->create();
        $calendarUid = $existingActivity->google_calendar_uid;

        $data = <<<CALENDAR
BEGIN:VCALENDAR
BEGIN:VEVENT
DTSTART:20200202T180000Z
DTEND:20200202T210000Z
DTSTAMP:20180503T094905Z
UID:{$calendarUid}
ATTENDEE;CUTYPE=INDIVIDUAL;ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;CN=Activi
 teitenkalender T.F.V. 'Professor Francken';X-NUM-GUESTS=0:mailto:g8f50ild2k
 df49bgathcdhvcqc@group.calendar.google.com
CREATED:20180411T143903Z
DESCRIPTION:HOI
LAST-MODIFIED:20180430T132554Z
LOCATION:5113.0202
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:Bitterballen Borrel
TRANSP:OPAQUE
END:VEVENT
BEGIN:VEVENT
DTSTART:20200101T180000Z
DTEND:20200101T210000Z
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

        $repo = app(ActivitiesRepository::class);
        $repo = new ActivitiesRepository($data);
        $this->app->instance(ActivitiesRepository::class, $repo);

        Artisan::call('activities:import');

        $existingActivity->refresh();
        $this->assertCount(2, Activity::all());
        $this->assertEquals('Bitterballen Borrel', $existingActivity->name);
        $this->assertEquals('20200202T180000', $existingActivity->start_date->format('Ymd\THis'));
        $this->assertEquals('20200202T210000', $existingActivity->end_date->format('Ymd\THis'));
    }
}
