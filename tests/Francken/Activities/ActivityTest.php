<?php

namespace Tests\Francken\Activities;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Activities\Activity;
use Francken\Activities\ActivityId;
use Francken\Activities\Location;

use Francken\Activities\Events\ActivityPlanned;
use Francken\Activities\Events\ActivityPublished;
use Francken\Activities\Events\ActivityCategorized;

use DateTime;

class ActivitiesTest extends AggregateRootScenarioTestCase
{
    private $generator;

    public function setUp()
    {
        parent::setUp();

        // We will use this generator to generate valid UUIDs
        $this->generator = new Version4Generator();
    }

    protected function getAggregateRootClass()
    {
        return Activity::class;
    }

    /** @test */
    public function an_activity_can_be_planned()
    {
        $id = new ActivityId($this->generator->generate());

        $this->scenario
            ->when(function () use ($id) {
                return Activity::plan(
                    $id,
                    'Crash & Compile',
                    'Programming competition',
                    new DateTime('2015-12-04'),
                    Location::fromNameAndAddress('Francken kamer'),
                    Activity::SOCIAL
                );
            })
            ->then([$this->socialActivityWasPlanned($id)]);
    }

    /** @test */
    public function once_an_activity_has_been_planned_it_can_be_published()
    {

        $id = new ActivityId($this->generator->generate());

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->publish();
            })
            ->then([new ActivityPublished($id)]);
    }

    /** @test */
    public function an_activity_can_be_recategorized()
    {
        $id = new ActivityId($this->generator->generate());

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->recategorize(
                    Activity::CAREER
                );
            })
            ->then([new ActivityCategorized($id, Activity::CAREER)]);
    }

    /**
     * @test
     * @expectedException \Francken\Activities\InvalidActivity
     */
    public function an_activity_can_only_be_categorized_into_valid_categories()
    {
        $id = new ActivityId($this->generator->generate());

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->recategorize("something");
            });
    }

    /** @test */
    public function recategorizing_an_activity_is_idempotent()
    {
        $id = new ActivityId($this->generator->generate());

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                $activity->recategorize(Activity::EDUCATION);
                return $activity->recategorize(Activity::EDUCATION);
            })
            ->then([new ActivityCategorized($id, Activity::EDUCATION)]);
    }

    private function givenAPlannedActivity(ActivityId $id)
    {
        return $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id)
            ]);
    }

    private function socialActivityWasPlanned(ActivityId $id)
    {
        return new ActivityPlanned(
            $id,
            'Crash & Compile',
            'Programming competition',
            new DateTime('2015-12-04'),
            Location::fromNameAndAddress('Francken kamer'),
            Activity::SOCIAL
        );
    }
}