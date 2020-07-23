<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\Http\Requests\SearchVacanciesRequest;
use Francken\Extern\JobType;
use Francken\Extern\Partner;
use Francken\Extern\Sector;
use Francken\Extern\SponsorOptions\Vacancy;
use Illuminate\View\View;

final class CareerController
{
    public function index() : View
    {
        return view('career.index');
    }

    public function jobs(SearchVacanciesRequest $request) : View
    {
        $vacancies = Vacancy::search($request)->get();
        $partners = Partner::query()
            ->has('vacancies')
            ->orderBy('name', 'asc')
            ->get();

        return view('career.job-openings')
            ->with([
                'request' => $request,
                'vacancies' => $vacancies,
                'partners' => $partners->mapWithKeys(function (Partner $partner) : array {
                    return [$partner->getKey() => $partner->name];
                })->prepend("Any", 0),
                'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                    return [$sector->getKey() => $sector->name];
                })->prepend("Any", 0),

                'sector_icons' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                    return [$sector->getKey() => $sector->icon];
                })->all(),
                'types' => JobType::TYPES
            ])
            ->with('breadcrumbs', [
                ['url' => '/career', 'text' => 'Career'],
                ['url' => '/career/job-openings', 'text' => 'Job openings'],
            ]);
    }
}
