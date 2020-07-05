<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use Illuminate\Http\Request;
use DateTime;
use DateTimeImmutable;
use Francken\Association\Activities\ActivitiesRepository;
use Francken\Association\Activities\CalendarEvent;

final class ApiActivitiesController
{
    public function index(ActivitiesRepository $activities, Request $request): array
    {
        $limit = (int) $request->get('limit', 10);
        $after = DateTimeImmutable::createFromFormat(
            'Y-m-d', $request->get('after', (new DateTimeImmutable())->format('Y-m-d'))
        );

        $map = function (CalendarEvent $activity): array {
            return [
                'title' => $activity->title(),
                'description' => $activity->description(),
                'location' => $activity->location(),
                'startDate' => $activity->startDate()->format(DateTime::ATOM),
                'endDate' => $activity->endDate()->format(DateTime::ATOM),
            ];
        };

        if ($request->has('before')) {
            $before = DateTimeImmutable::createFromFormat(
                'Y-m-d', $request->get('before')
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
