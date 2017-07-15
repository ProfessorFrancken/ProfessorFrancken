<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Francken\Application\Career\JobOpeningRepository;
use Francken\Application\Career\Sector;
use Francken\Application\Career\JobType;

final class CareerController
{
    public function jobs(JobOpeningRepository $repo)
    {
        $jobs = $repo->search(
            request()->input('job-title', null),
            request()->input('company', null),
            Sector::fromString(request()->input('sector', '')),
            JobType::fromString(request()->input('jobType', ''))
        );

        $jobs = (collect($jobs)->shuffle());

        return view('pages.career.job-openings')
            ->with([
                'jobs' => $jobs,
                'companies' => $repo->companies(),
                'sectors' => Sector::SECTORS,
                'types' => JobType::TYPES
            ]);
    }
}
