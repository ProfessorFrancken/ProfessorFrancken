<?php

declare(strict_types=1);

namespace Francken\Api\Http;

use Francken\Application\Career\JobOpeningRepository;

final class JobOpeningsController
{
    public function index(JobOpeningRepository $jobOpenings)
    {
        return [
            'job-openings' => collect($jobOpenings->search())->map(
                function (array $job) {
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
