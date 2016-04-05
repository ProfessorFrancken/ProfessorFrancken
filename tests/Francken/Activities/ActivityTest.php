<?php

namespace Tests\Francken\Activities;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Francken\Domain\Activities\Activity;
use Francken\Domain\Activities\ActivityId;
use Francken\Domain\Activities\Location;
use Francken\Domain\Activities\Schedule;
use Francken\Domain\Activities\InvalidActivity;
use Francken\Domain\Activities\Events\ActivityPlanned;
use Francken\Domain\Activities\Events\ActivityPublished;
use Francken\Domain\Activities\Events\ActivityCancelled;
use Francken\Domain\Activities\Events\ActivityCategorized;
use Francken\Domain\Activities\Events\ActivityRescheduled;
use Francken\Domain\Activities\Events\MemberRegisteredToParticipate;
use Francken\Domain\Members\MemberId;

use DateTimeImmutable;

class ActivitiesTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass()
    {
        return Activity::class;
    }

    /** @test */
    public function an_activity_can_be_planned()
    {
        $id = ActivityId::generate();

        $this->scenario
            ->when(function () use ($id) {
                return Activity::plan(
                    $id,
                    'Crash & Compile',
                    'Programming competition',
                    Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
                    Location::fromNameAndAddress('Francken kamer'),
                    Activity::SOCIAL
                );
            })
            ->then([$this->socialActivityWasPlanned($id)]);
    }

    /** @test */
    public function once_an_activity_has_been_planned_it_can_be_published()
    {
        $id = ActivityId::generate();

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->publish();
            })
            ->then([new ActivityPublished($id)]);
    }

    /** @test */
    public function a_published_activity_can_be_cancelled()
    {
        $id = ActivityId::generate();

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
     */
    public function a_draft_activity_cant_be_cancelled()
    {
        $this->expectException(InvalidActivity::class);
        $id = ActivityId::generate();

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->cancel();
            });
    }

    /**
     * @test
     */
    public function a_published_activity_cant_be_published_again()
    {
        $this->expectException(InvalidActivity::class);
        $id = ActivityId::generate();

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
     */
    public function a_cancelled_activity_cant_be_cancelled_again()
    {
        $this->expectException(InvalidActivity::class);
        $id = ActivityId::generate();

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
        $id = ActivityId::generate();

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
     */
    public function an_activity_can_only_be_categorized_into_valid_categories()
    {
        $this->expectException(InvalidActivity::class);
        $id = ActivityId::generate();

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) {
                return $activity->recategorize("something");
            });
    }

    /** @test */
    public function recategorizing_an_activity_is_idempotent()
    {
        $id = ActivityId::generate();

        $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id, [
                    'category' => Activity::EDUCATION
                ]),
            ])
            ->when(function ($activity) {
                return $activity->recategorize(Activity::EDUCATION);
            })
            ->then([]);

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
     */
    public function a_member_cant_register_to_participate_in_activity_that_isnt_published()
    {
        $this->expectException(InvalidActivity::class);
        $id = ActivityId::generate();
        $memberId = MemberId::generate();

        $this->givenAPlannedActivity($id)
            ->when(function ($activity) use ($memberId) {
                return $activity->registerParticipant($memberId);
            });
    }

    /** @test */
    public function a_member_can_register_to_participate_in_a_published_activity()
    {
        $id = ActivityId::generate();
        $memberId = MemberId::generate();

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
        $id = ActivityId::generate();
        $memberId = MemberId::generate();

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

    /** @test */
    public function rescheduling_an_activity()
    {
        $id = ActivityId::generate();

        $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id),
            ])
            ->when(function ($activity) {
                return $activity->reschedule(
                    Schedule::forPeriod(
                        new DateTimeImmutable('2015-10-03 14:30'),
                        new DateTimeImmutable('2015-10-03 15:30')
                    )
                );
            })
            ->then([
                new ActivityRescheduled(
                    $id,
                    Schedule::forPeriod(
                        new DateTimeImmutable('2015-10-03 14:30'),
                        new DateTimeImmutable('2015-10-03 15:30')
                    )
                )
            ]);
    }

    /** @test */
    public function an_activity_isnt_rescheduled_when_the_same_period_is_given()
    {
        $id = ActivityId::generate();

        $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id, [
                    'schedule' => Schedule::forPeriod(
                        new DateTimeImmutable('2015-10-03 14:30'),
                        new DateTimeImmutable('2015-10-03 15:30')
                    )
                ]),
            ])
            ->when(function ($activity) {
                return $activity->reschedule(
                    Schedule::forPeriod(
                        new DateTimeImmutable('2015-10-03 14:30'),
                        new DateTimeImmutable('2015-10-03 15:30')
                    )
                );
            })
            ->then([]);


        // It should also be idempotent when repeatedly rescheduling an activity
        $this->scenario
            ->withAggregateId($id)
            ->given([
                $this->socialActivityWasPlanned($id),
                new ActivityRescheduled(
                    $id,
                    Schedule::forPeriod(
                        new DateTimeImmutable('2015-10-03 14:30'),
                        new DateTimeImmutable('2015-10-03 15:30')
                    )
                )
            ])
            ->when(function ($activity) {
                return $activity->reschedule(
                    Schedule::forPeriod(
                        new DateTimeImmutable('2015-10-03 14:30'),
                        new DateTimeImmutable('2015-10-03 15:30')
                    )
                );
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

    /**
     * Creates an ActivityPlanned event given an id and some options.
     * The options array can override the given default values.
     */
    private function socialActivityWasPlanned(ActivityId $id, array $options = []) : ActivityPlanned
    {
        $options = array_merge([
            'schedule' => Schedule::withStartTime(new DateTimeImmutable('2015-10-01 14:30')),
            'category' => Activity::SOCIAL
        ], $options);

        return new ActivityPlanned(
            $id,
            'Crash & Compile',
            'Programming competition',
            $options['schedule'],
            Location::fromNameAndAddress('Francken kamer'),
            $options['category']
        );
    }
}
