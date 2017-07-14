<?php

declare(strict_types=1);

namespace Francken\Application\Career;

final class JobOpeningRepository
{
    private $jobs;

    public function __construct(string $filename = '')
    {
        $this->loadJobsFromPHPFile($filename);
    }

    /**
     * Returns all companies that have 1 or more job openings
     */
    public function companies() : array
    {
        $jobs = collect($this->jobs);

        return $jobs->map(function ($job) {
                return $job['name'];
        })->unique()->toArray();
    }

    public function search(
        string $title = null,
        string $company = null,
        Sector $sector = null,
        JobType $type = null
    ) : array {
        $jobs = collect($this->jobs);

        if (! is_null($title) && $title != '') {
            $jobs = $jobs->filter(function ($job) use ($title) {
                return str_contains($job['job'], $title);
            });
        }

        if (! is_null($company) && $company != '') {
            $jobs = $jobs->filter(function ($job) use ($company) {
                return str_contains($job['name'], $company);
            });
        }

        if (! is_null($sector)) {
            $jobs = $jobs->filter(function ($job) use ($sector) {
                return $job['sector'] == (string) $sector;
            });

        }

        if (! is_null($type)) {
            $jobs = $jobs->filter(function ($job) use ($type) {
                return $job['type'] == (string) $type;
            });
        }

        return $jobs->toArray();
    }

    private function loadJobsFromPHPFile(string $filename)
    {
        // Idea: if no job description was given, default to company job description
        $this->jobs = (require database_path('vacancies.php'));
    }
}
