<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use DateInterval;
use DateTimeImmutable;
use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\IcalController;
use Francken\Features\TestCase;

class ActivitiesFeature extends TestCase
{
    private DateTimeImmutable $start;

    protected function setUp() : void
    {
        parent::setUp();

        $tomorrow = new DateTimeImmutable('tomorrow +1day');
        $this->start = $tomorrow;

        factory(Activity::class)->create([
            'start_date' => $tomorrow,
            'end_date' => $tomorrow,
            'name' => 'Lunch lecture: Demcon'
        ]);
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

    /** @test */
    public function it_shows_instructions_to_import_activities_in_a_calendar() : void
    {
        $this->visit(action([IcalController::class, 'index']))
            ->see('Google Calendar')
            ->see('Outlook Calendar');
    }

    /** @test */
    public function it_downloads_a_calendar() : void
    {
        $this->visit(action([IcalController::class, 'show']))
            ->assertResponseOk();
    }
}
