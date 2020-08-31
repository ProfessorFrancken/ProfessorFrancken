<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Extern\Http\ApiJobOpeningsController;
use Francken\Extern\SponsorOptions\Vacancy;
use Francken\Features\TestCase;

class ApiJobOpeningsFeature extends TestCase
{
    /** @test */
    public function it_returns_current_job_openings() : void
    {
        factory(Vacancy::class, 3)->create();

        $this->json(
            'GET',
            action([ApiJobOpeningsController::class, 'index']),
        )->assertResponseStatus(200)
            ->seeJsonStructure([
            'job-openings' => [[
                "name",
                "link",
                "type",
                "sector",
                "description",
                "company" => [
                    'name',
                    'logo'
                ],
            ]]
        ]);
    }
}
