<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\JobOpeningRepository;
use Francken\Extern\JobType;
use Francken\Extern\Sector;
use Francken\Shared\AcademicYear;
use Francken\Shared\Clock\Clock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class CareerController
{
    public function index() : View
    {
        return view('career.index');
    }

    public function jobs(JobOpeningRepository $repo, Request $request) : View
    {
        $jobs = $repo->search(
            $request->input('job-title', null),
            $request->input('company', null),
            Sector::whereName((string)$request->input('sector', ''))->first(),
            JobType::fromString((string)$request->input('jobType', ''))
        );

        return view('career.job-openings')
            ->with([
                'jobs' => $jobs,
                'companies' => $repo->companies(),
                'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                    return [$sector->name => $sector->icon];
                })->all(),
                'types' => JobType::TYPES
            ])
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/job-openings', 'text' => 'Job openings'],
            ]);
    }
}
