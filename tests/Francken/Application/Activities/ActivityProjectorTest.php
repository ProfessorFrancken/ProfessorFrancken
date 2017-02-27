<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Activities;

use DateTimeImmutable;
use Francken\Application\Activities\Activity;
use Francken\Application\Activities\ActivityProjector;
use Francken\Application\Activities\ActivityRepository;

//domain
use Francken\Application\Projector;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Events\ActivityPlanned;

//application
use Francken\Domain\Activities\Location;
use Francken\Domain\Activities\Schedule;
use Francken\Infrastructure\Repositories\InMemoryRepository;

//events
use Francken\Tests\Application\ProjectorScenarioTestCase as TestCase;

class ActivityProjectorTest extends TestCase
{
    /** @test */
    public function it_stores_a_committee()
    {
        $id = ActivityId::generate();

        $this->scenario->when(
            new ActivityPlanned(
                $id,
                'Crash & Compile',
                'Programming competition',
                Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
                Location::fromNameAndAddress('Francken kamer'),
                \Francken\Domain\Activities\Activity::SOCIAL)
        )->then([
            new Activity(
                $id,
                'Crash & Compile',
                false,
                // 'Programming competition',
                \Francken\Domain\Activities\Activity::SOCIAL,
                Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
                Location::fromNameAndAddress('Francken kamer'),
                []
            )
        ]);
    }


    protected function createProjector(InMemoryRepository $repository) : Projector
    {
        return new ActivityProjector(
            new ActivityRepository(
                $repository
            )
        );
    }
}
