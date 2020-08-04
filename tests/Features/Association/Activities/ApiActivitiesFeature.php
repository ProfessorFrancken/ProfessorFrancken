<?php

declare(strict_types=1);

namespace Francken\Features\Association\Activities;

use DateTimeImmutable;
use Francken\Association\Activities\Activity;
use Francken\Association\Activities\Http\ApiActivitiesController;
use Francken\Features\TestCase;

class ApiActivitiesFeature extends TestCase
{
    /** @test */
    public function it_shows_upcoming_activities() : void
    {
        $this->withoutExceptionHandling();
        $this->json('POST', '/api/plus-one/authenticate', [
            'password' => 'hoi',
        ]);
        $token = $this->response->decodeResponseJson()['token'];

        $tomorrow = new DateTimeImmutable('tomorrow +1day');
        $activity = factory(Activity::class)->create([
            'start_date' => $tomorrow,
            'end_date' => $tomorrow,
            'name' => 'Lunch lecture: Demcon'
        ]);

        $this->json(
            'GET',
            action([ApiActivitiesController::class, 'index']),
            [],
            ['Authorization' => 'Bearer ' . $token]
        );
        $this->assertResponseStatus(200);
        $this->seeJsonStructure([
            'activities' => [[
                "title",
                "description",
                "location",
                'startDate',
                'endDate'
            ]]
        ]);
        $this->seeJsonEquals([
            'activities' => [
                [
                    "title" => $activity->name,
                    "description" => $activity->compiled_content,
                    "location" => $activity->location,
                    'startDate' => $activity->start_date->format(DateTimeImmutable::ATOM),
                    'endDate' => $activity->end_date->format(DateTimeImmutable::ATOM),
                ]
            ],
        ]);
    }
}
