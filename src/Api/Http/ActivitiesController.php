<?php

declare(strict_types=1);

namespace Francken\Api\Http;

use DateTime;
use DateTimeImmutable;
use Francken\Association\Activities\ActivitiesRepository;
use Francken\Association\Activities\CalendarEvent;

final class ActivitiesController
{
    public function index(ActivitiesRepository $activities)
    {
        $today = new DateTimeImmutable;
        $limit = (int) request()->get('limit', 10);
        return $activities->after($today, $limit)
            ->map(function (CalendarEvent $activity) {
                return [
                    'title' => $activity->title(),
                    'description' => $activity->description(),
                    'location' => $activity->location(),
                    'startDate' => $activity->startDate()->format(DateTime::ATOM),
                    'endDate' => $activity->endDate()->format(DateTime::ATOM),
                ];
            });
    }
}
