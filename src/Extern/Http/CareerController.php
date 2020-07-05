<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\EventRepository;
use Francken\Extern\JobOpeningRepository;
use Francken\Extern\JobType;
use Francken\Extern\Sector;
use Francken\Shared\AcademicYear;
use Francken\Shared\Clock\Clock;
use Illuminate\Support\Str;

final class CareerController
{
    public function index()
    {
        return view('career.index');
    }

    public function jobs(JobOpeningRepository $repo)
    {
        $jobs = $repo->search(
            request()->input('job-title', null),
            request()->input('company', null),
            Sector::whereName((string)request()->input('sector', ''))->first(),
            JobType::fromString((string)request()->input('jobType', ''))
        );

        return view('career.job-openings')
            ->with([
                'jobs' => $jobs,
                'companies' => $repo->companies(),
                'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) {
                    return [$sector->name => $sector->icon];
                })->all(),
                'types' => JobType::TYPES
            ])
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/job-openings', 'text' => 'Job openings'],
            ]);
    }

    public function redirectEvents(Clock $clock)
    {
        $academicYear = AcademicYear::fromDate($clock->now());

        return redirect('/career/events/' . Str::slug($academicYear->toString()));
    }

    public function events(EventRepository $repo, Clock $clock, AcademicYear $year = null)
    {
        $plannedEvents = $repo->plannedInYear($year);
        $pastEvents = $repo->pastInYear($year);
        $today = $clock->now();

        return view('career.events')
            ->with([
                'pastEvents' => $pastEvents,
                'plannedEvents' => $plannedEvents,
                'year' => $year,
                'showNextYear' => $today > $year->end()
            ])
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/events', 'text' => 'Career events'],
            ]);
    }
}
