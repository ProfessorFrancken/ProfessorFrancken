<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\SponsorOptions\Vacancy;
use Webmozart\Assert\Assert;

final class ApiJobOpeningsController
{
    public function index() : array
    {
        $vacancies = Vacancy::query()
            ->with(['sector', 'partner', 'partner.logoMedia'])
            ->get();

        return [
            'job-openings' => $vacancies->map(
                function (Vacancy $vacancy) : array {
                    Assert::notNull($vacancy->sector);
                    Assert::notNull($vacancy->partner);

                    return [
                        'name' => $vacancy->title,
                        'link' => $vacancy->vacancy_url,
                        'type' => $vacancy->type,
                        'sector' => $vacancy->sector->name,
                        'description' => $vacancy->description,
                        'company' => [
                            'name' => $vacancy->partner->name,
                            'logo' => $vacancy->partner->logo,
                        ],
                    ];
                })->values()
        ];
    }
}
