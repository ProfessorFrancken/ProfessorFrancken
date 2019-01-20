<?php

declare(strict_types=1);

namespace Francken\Infrastructure\Http\Controllers;

use Francken\Application\Career\JobOpeningRepository;
use Francken\Application\Career\AcademicYear;
use Francken\Application\Career\EventRepository;
use Francken\Application\Career\JobType;
use Francken\Application\Career\Sector;
use Francken\Domain\Boards\BoardRepository;
use Francken\Domain\Boards\BoardYear;

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
            Sector::fromString(request()->input('sector', '')),
            JobType::fromString(request()->input('jobType', ''))
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

    public function redirectEvents(EventRepository $repo, BoardRepository $boards)
    {
        $academicYear = AcademicYear::fromDate(new \DateTimeImmutable);

        return redirect('/career/events/' . str_slug($academicYear->toString()));
    }

    public function events(EventRepository $repo, BoardRepository $boards, AcademicYear $year = null)
    {
        // boards->findBoardAfter($year), before

        $plannedEvents = $repo->plannedInYear($year);
        $pastEvents = $repo->pastInYear($year);
        $today = new \DateTimeImmutable;

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
