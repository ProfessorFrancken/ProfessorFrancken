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
        $limit = (int) request()->get('limit', 10);
        $after = DateTimeImmutable::createFromFormat(
            'Y-m-d', request()->get('after', (new DateTimeImmutable())->format('Y-m-d'))
        );

        $map = function (CalendarEvent $activity) {
            return [
                'title' => $activity->title(),
                'description' => $activity->description(),
                'location' => $activity->location(),
                'startDate' => $activity->startDate()->format(DateTime::ATOM),
                'endDate' => $activity->endDate()->format(DateTime::ATOM),
            ];
        };

        if (request()->has('before')) {
            $before = DateTimeImmutable::createFromFormat(
                'Y-m-d', request()->get('before')
            );

            return [
                'activities' => $activities->between($after, $before)->map($map)->values()
            ];
        }

        return [
            'activities' => $activities->after($after, $limit)->map($map)->values()
        ];
    }
}
