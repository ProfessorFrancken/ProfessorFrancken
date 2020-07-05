<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Support\Str;

final class JobOpeningRepository
{
    /**
     * @var mixed[]
     */
    private array $jobs = [];

    public function __construct(array $jobs = [])
    {
        $this->jobs = $jobs;
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
        ?Sector $sector = null,
        ?JobType $type = null
    ) : array {
        $jobs = collect($this->jobs);

        if ( ! is_null($title) && $title != '') {
            $jobs = $jobs->filter(function ($job) use ($title) : bool {
                return Str::contains($job['job'], $title);
            });
        }

        if ( ! is_null($company) && $company != '') {
            $jobs = $jobs->filter(function ($job) use ($company) : bool {
                return Str::contains($job['name'], $company);
            });
        }

        if ( ! is_null($sector)) {
            $jobs = $jobs->filter(function ($job) use ($sector) : bool {
                return $job['sector'] == (string) $sector->name;
            });
        }

        if ( ! is_null($type)) {
            $jobs = $jobs->filter(function ($job) use ($type) : bool {
                return $job['type'] == (string) $type;
            });
        }

        return $jobs->toArray();
    }
}
