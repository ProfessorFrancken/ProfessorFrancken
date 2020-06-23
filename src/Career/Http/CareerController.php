<?php

declare(strict_types=1);

namespace Francken\Career\Http;

use Francken\Career\AcademicYear;
use Francken\Career\EventRepository;
use Francken\Career\JobOpeningRepository;
use Francken\Career\JobType;
use Francken\Career\Sector;
use Francken\Shared\Clock\Clock;

final class CareerController
{
    public function __construct()
    {
        // perhaps we can bind the BoardYear route here?
    }

    public function index()
    {
        return view('career.index');
    }

    public function jobs(JobOpeningRepository $repo)
    {
        $jobs = $repo->search(
            request()->input('job-title', null),
            request()->input('company', null),
            Sector::fromString((string)request()->input('sector', '')),
            JobType::fromString((string)request()->input('jobType', ''))
        );

        return view('career.job-openings')
            ->with([
                'jobs' => $jobs,
                'companies' => $repo->companies(),
                'sectors' => Sector::SECTORS,
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

        return redirect('/career/events/' . str_slug($academicYear->toString()));
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
