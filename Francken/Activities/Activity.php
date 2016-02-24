<?php

namespace Francken\Activities;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Activities\Events\ActivityPlanned;
use Francken\Activities\Events\ActivityPublished;
use Francken\Activities\Events\ActivityRetracted;
use Francken\Activities\Events\ActivityCategorized;

use DateTimeImmutable;

final class Activity extends EventSourcedAggregateRoot
{
    private $id;
    private $published = false;
    private $category;

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

    public function retract()
    {
        if (! $this->published)
        {
            throw InvalidActivity::cantRetractADraft();
        }

        $this->apply(new ActivityRetracted($this->id));
    }

    public function recategorize($category)
    {
        $this->assertCategoryIsValid($category);

        if ($this->category === $category)
            return;

        $this->apply(new ActivityCategorized($this->id, $category));
    }

    public function applyActivityPlanned(ActivityPlanned $event)
    {
        $this->id = $event->activityId();
    }

    public function applyActivityPublished(ActivityPublished $event)
    {
        $this->published = true;
    }

    public function applyActivityRetracted(ActivityRetracted $event)
    {
        $this->published = false;
    }

    public function applyActivityCategorized(ActivityCategorized $event)
    {
        $this->category = $event->category();
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