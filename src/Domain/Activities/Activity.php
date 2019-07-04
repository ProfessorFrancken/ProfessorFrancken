<?php

declare(strict_types=1);

namespace Francken\Domain\Activities;

use Francken\Domain\Activities\Events\ActivityCancelled;
use Francken\Domain\Activities\Events\ActivityCategorized;
use Francken\Domain\Activities\Events\ActivityPlanned;
use Francken\Domain\Activities\Events\ActivityPublished;
use Francken\Domain\Activities\Events\ActivityRescheduled;
use Francken\Domain\Activities\Events\MemberRegisteredToParticipate;
use Francken\Domain\AggregateRoot;
use Francken\Domain\Members\MemberId;

final class Activity extends AggregateRoot
{
    public const SOCIAL = 'social';
    public const CAREER = 'career';
    public const EDUCATION = 'education';

    private $id;
    private $published = false;
    private $category;
    private $schedule;
    private $members = [];

    public static function plan(
        ActivityId $id,
        $name,
        $description,
        Schedule $schedule,
        Location $location,
        $type
    ) {
        $activity = new self();

        $activity->apply(new ActivityPlanned($id, $name, $description, $schedule, $location, $type));

        return $activity;
    }

    public function publish() : void
    {
        if ($this->published) {
            throw InvalidActivity::alreadyPublished();
        }

        $this->apply(new ActivityPublished($this->id));
    }

    public function cancel()
    {
        if (! $this->published) {
            throw InvalidActivity::cantCancelADraft();
        }

        $this->apply(new ActivityCancelled($this->id));
    }

    public function recategorize($category)
    {
        $this->assertCategoryIsValid($category);

        if ($this->category === $category) {
            return;
        }

        $this->apply(new ActivityCategorized($this->id, $category));
    }

    public function reschedule(Schedule $schedule)
    {
        if ($this->schedule == $schedule) {
            return;
        }

        $this->apply(new ActivityRescheduled(
            $this->id,
            $schedule
        ));
    }

    public function registerParticipant(MemberId $memberId)
    {
        if (! $this->published) {
            throw new InvalidActivity("Tried to register member {$memberId}, but activity isn't published");
        }

        if (in_array($memberId, $this->members)) {
            return;
        }

        $this->apply(new MemberRegisteredToParticipate($this->id, $memberId));
    }

    protected function applyActivityPlanned(ActivityPlanned $event)
    {
        $this->id = $event->activityId();
        $this->schedule = $event->schedule();
        $this->category = $event->category();
    }

    protected function applyActivityPublished(ActivityPublished $event)
    {
        $this->published = true;
    }

    protected function applyActivityCancelled(ActivityCancelled $event)
    {
        $this->published = false;
    }

    protected function applyActivityCategorized(ActivityCategorized $event)
    {
        $this->category = $event->category();
    }

    protected function applyActivityRescheduled(ActivityRescheduled $event)
    {
        $this->schedule = $event->schedule();
    }

    protected function applyMemberRegisteredToParticipate(MemberRegisteredToParticipate $event)
    {
        $this->members[] = $event->memberId();
    }

    public function getAggregateRootId() : string
    {
        return (string)$this->id;
    }

    private function assertCategoryIsValid($category)
    {
        if (! in_array($category, [
            Activity::SOCIAL,
            Activity::CAREER,
            Activity::EDUCATION
        ])) {
            throw InvalidActivity::invalidCategory($category);
        }
    }
}
