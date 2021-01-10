<?php

declare(strict_types=1);

namespace Francken\Association\Activities\Http;

use DateTime;
use DateTimeImmutable;
use Francken\Association\Activities\Activity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Webmozart\Assert\Assert;

final class ApiActivitiesController
{
    public function index(Request $request) : array
    {
        $after = DateTimeImmutable::createFromFormat(
            'Y-m-d', $request->get('after', (new DateTimeImmutable())->format('Y-m-d'))
        );
        Assert::isInstanceOf($after, DateTimeImmutable::class);


        $activities = Activity::query()
            ->orderBy('start_date', 'asc')
            ->where('start_date', '>', $after)
            ->when($request->input('before'), function (Builder $query, string $before) : void {
                $before = DateTimeImmutable::createFromFormat('Y-m-d', $before);
                Assert::isInstanceOf($before, DateTimeImmutable::class);
                $query->where('start_date', '<', $before);
            })
            ->get()
            ->map(fn (Activity $activity) : array => [
                'title' => $activity->name,
                'description' => $activity->compiled_content,
                'location' => $activity->location,
                'startDate' => $activity->start_date->format(DateTime::ATOM),
                'endDate' => $activity->end_date->format(DateTime::ATOM),
            ])
            ->values();

        return [
            'activities' => $activities
        ];
    }
}
