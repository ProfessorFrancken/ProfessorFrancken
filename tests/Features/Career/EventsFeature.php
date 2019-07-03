<?php

declare(strict_types=1);

namespace Francken\Features\Career;

use DateTimeImmutable;
use Francken\Application\Career\EventRepository;
use Francken\Features\TestCase;
use Francken\Shared\Clock\Clock;
use Francken\Shared\Clock\FrozenClock;

final class EventsFeature extends TestCase
{
    /** @test */
    public function if_no_year_is_given_events_from_the_current_board_are_shown() : void
    {
        $this->app->bind(EventRepository::class, function ($app) {
            return new EventRepository([], []);
        });
        $this->app->instance(
            Clock::class,
            new FrozenClock(DateTimeImmutable::createFromFormat('Y-m-d', '2019-06-06'))
        );

        $this->visit('/career/events')
            ->seePageIs('/career/events/2018-2019');

        $this->assertResponseOk();
    }
}
