<?php

declare(strict_types=1);

namespace Francken\Tests\Application\Activities;

use DateTimeImmutable;
use Francken\Application\Projector;
use Francken\Tests\Application\ProjectorScenarioTestCase as TestCase;
use Francken\Infrastructure\Repositories\InMemoryRepository;

//domain
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Schedule;
use Francken\Domain\Activities\Location;

//application
use Francken\Application\Activities\Activity;
use Francken\Application\Activities\ActivityProjector;
use Francken\Application\Activities\ActivityRepository;

//events
use Francken\Domain\Activities\Events\ActivityCancelled;
use Francken\Domain\Activities\Events\ActivityCategorized;
use Francken\Domain\Activities\Events\ActivityPlanned;
use Francken\Domain\Activities\Events\ActivityPublished;
use Francken\Domain\Activities\Events\ActivityRescheduled;
use Francken\Domain\Activities\Events\MemberRegisteredToParticipate;


class ActivityProjectorTest extends TestCase
{
    /** @test */
    public function it_stores_a_committee()
    {
        $id = ActivityId::generate();

        $this->scenario->when(
            new ActivityPlanned(
                $id,
                "Crash & Compile",
                "Programming competition",
                Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
                Location::fromNameAndAddress("Francken kamer"),
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
        return new ActivityProjector (
            new ActivityRepository(
                $repository
            )
        );
    }
}
