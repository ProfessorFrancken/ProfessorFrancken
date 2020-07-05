<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\JobOpeningRepository;

final class ApiJobOpeningsController
{
    public function index(JobOpeningRepository $jobOpenings): array
    {
        return [
            'job-openings' => collect($jobOpenings->search())->map(
                function (array $job): array {
                    return [
                        'name' => $job['job'],
                        'link' => $job['link'],
                        'type' => $job['type'],
                        'sector' => $job['sector'],
                        'description' => $job['description'] ?? '',
                        'company' => [
                            'name' => $job['name'],
                            'logo' => $job['logo'],
                        ],
                    ];
                })->values()
        ];
    }
}
