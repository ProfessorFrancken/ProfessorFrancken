<?php

declare(strict_types=1);


namespace Francken\Features\Career;

use Francken\Application\Career\EventRepository;
use Francken\Features\TestCase;

final class EventsFeature extends TestCase
{
    /** @test */
    function if_no_year_is_given_events_from_the_current_board_are_shown()
    {
        $this->app->bind(EventRepository::class, function ($app) {
            return new EventRepository([], []);
        });


        // setup boards repo
        $this->visit('/career/events')
            ->seePageIs('/career/events/2018-2019');

        $this->assertResponseOk();
    }

}
