<?php

namespace Francken\Activities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Activities\Events\ActivityPlanned;
use Francken\Activities\Events\ActivityPublished;
use Francken\Activities\Events\ActivityCancelled;
use Francken\Activities\Events\ActivityCategorized;
use Francken\Activities\Events\MemberRegisteredToParticipate;

use Francken\Members\MemberId;

use DateTimeImmutable;

final class Activity extends EventSourcedAggregateRoot
{
    private $id;
    private $published = false;
    private $category;
    private $members = [];

    const SOCIAL = 'social';
    const CAREER = 'career';
    const EDUCATION = 'education';

    public static function plan(
        ActivityId $id,
        $name,
        $description,
        DateTimeImmutable $time,
        Location $location,
        $type
    )
    {
        $activity = new Activity;

        $activity->apply(new ActivityPlanned($id, $name, $description, $time, $location, $type));

        return $activity;
    }

    public function publish()
    {
        if ($this->published)
        {
            throw InvalidActivity::alreadyPublished();
        }

        $this->apply(new ActivityPublished($this->id));
    }

    public function cancel()
    {
        if (! $this->published)
        {
            throw InvalidActivity::cantCancelADraft();
        }

        $this->apply(new ActivityCancelled($this->id));
    }

    public function recategorize($category)
    {
        $this->assertCategoryIsValid($category);

        if ($this->category === $category)
            return;

        $this->apply(new ActivityCategorized($this->id, $category));
    }

    public function registerParticipant(MemberId $memberId)
    {
        if (! $this->published)
        {
            throw new InvalidActivity("Tried to register member {$memberId}, but activity isn't published");
        }

        if (in_array($memberId, $this->members))
        {
            return;
        }

        $this->apply(new MemberRegisteredToParticipate($this->id, $memberId));
    }

    protected function applyActivityPlanned(ActivityPlanned $event)
    {
        $this->id = $event->activityId();
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

    protected function applyMemberRegisteredToParticipate(MemberRegisteredToParticipate $event)
    {
        $this->members[] = $event->memberId();
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }

    private function assertCategoryIsValid($category)
    {
        if (! in_array($category, [
            Activity::SOCIAL,
            Activity::CAREER,
            Activity::EDUCATION
        ]))
        {
            throw InvalidActivity::invalidCategory($category);
        }
    }
}