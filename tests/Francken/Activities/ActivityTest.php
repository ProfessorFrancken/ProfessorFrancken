<?php

namespace Tests\Francken\Activities;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\UuidGenerator\Rfc4122\Version4Generator;

use Francken\Activities\Activity;
use Francken\Activities\ActivityId;
use Francken\Activities\Location;

use Francken\Activities\Events\ActivityPlanned;
use Francken\Activities\Events\ActivityPublished;
use Francken\Activities\Events\ActivityCancelled;
use Francken\Activities\Events\ActivityCategorized;
use Francken\Activities\Events\MemberRegisteredToParticipate;

use Francken\Members\MemberId;

use DateTimeImmutable;

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
                    new DateTimeImmutable('2015-12-04'),
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
    public function a_published_activity_can_be_cancelled()
    {
        $id = new ActivityId($this->generator->generate());

        return $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id),
                new ActivityPublished($id)
            ])
            ->when(function ($activity) {
                return $activity->cancel();
            })
            ->then([new ActivityCancelled($id)]);
    }

    /**
     * @test
     * @expectedException \Francken\Activities\InvalidActivity
     */
    public function a_draft_activity_cant_be_cancelled()
    {
        $id = new ActivityId($this->generator->generate());

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->cancel();
            });
    }

    /**
     * @test
     * @expectedException \Francken\Activities\InvalidActivity
     */
    public function a_published_activity_cant_be_published_again()
    {
        $id = new ActivityId($this->generator->generate());

        return $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id),
                new ActivityPublished($id)
            ])
            ->when(function ($activity) {
                return $activity->publish();
            });
    }

    /**
     * @test
     * @expectedException \Francken\Activities\InvalidActivity
     */
    public function a_cancelled_activity_cant_be_cancelled_again()
    {
        $id = new ActivityId($this->generator->generate());

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                $activity->publish();
                $activity->cancel();
                return $activity->cancel();
            });
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

        $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id),
                new ActivityCategorized($id, Activity::EDUCATION)
            ])
            ->when(function ($activity) {
                return $activity->recategorize(Activity::EDUCATION);
            })
            ->then([]);
    }

    /**
     * @test
     * @expectedException \Francken\Activities\InvalidActivity
     */
    public function a_member_cant_register_to_participate_in_activity_that_isnt_published()
    {
        $id = new ActivityId($this->generator->generate());
        $memberId = new MemberId($this->generator->generate());

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) use ($memberId) {
                return $activity->registerParticipant($memberId);
            });
    }

    /** @test */
    public function a_member_can_register_to_participate_in_a_published_activity()
    {
        $id = new ActivityId($this->generator->generate());
        $memberId = new MemberId($this->generator->generate());

        $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id),
                new ActivityPublished($id)
            ])
            ->when(function ($activity) use ($memberId) {
                return $activity->registerParticipant($memberId);
            })
            ->then([new MemberRegisteredToParticipate($id, $memberId)]);
    }

    /** @test */
    public function registering_a_member_is_idempotent()
    {
        $id = new ActivityId($this->generator->generate());
        $memberId = new MemberId($this->generator->generate());

        $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id),
                new ActivityPublished($id),
                new MemberRegisteredToParticipate($id, $memberId)
            ])
            ->when(function ($activity) use ($memberId) {
                return $activity->registerParticipant($memberId);
            })
            ->then([]);
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
            new DateTimeImmutable('2015-12-04'),
            Location::fromNameAndAddress('Francken kamer'),
            Activity::SOCIAL
        );
    }
}