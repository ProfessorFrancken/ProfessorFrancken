<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\Http\Requests\VacancyRequest;
use Francken\Extern\JobType;
use Francken\Extern\Partner;
use Francken\Extern\Sector;
use Francken\Extern\SponsorOptions\Vacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminVacanciesController
{
    public function create(Partner $partner) : View
    {
        return view('admin.extern.partners.sponsor-options.vacancies.create', [
            'partner' => $partner,
            'vacancy' => new Vacancy(),
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                return [$sector->getKey() => $sector->name];
            }),
            'types' => JobType::all(),
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'create'], ['partner' => $partner]), 'text' => 'Add vacancy'],
            ]
        ]);
    }

    public function store(VacancyRequest $request, Partner $partner) : RedirectResponse
    {
        $partner->vacancies()->save(
            new Vacancy([
                'title' => $request->title(),
                'description' => $request->description(),
                'sector_id' => $request->sectorId(),
                'type' => $request->type(),
                'vacancy_url' => $request->vacancyUrl() ?? $partner->referral_url,
            ])
        );

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function edit(Partner $partner, Vacancy $vacancy) : View
    {
        return view('admin.extern.partners.sponsor-options.vacancies.edit', [
            'partner' => $partner,
            'vacancy' => $vacancy,
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                return [$sector->getKey() => $sector->name];
            }),
            'types' => JobType::all(),
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'edit'], ['partner' => $partner, 'vacancy' => $vacancy]), 'text' => 'Edit vacancy'],
            ]
        ]);
    }

    public function update(VacancyRequest $request, Partner $partner, Vacancy $vacancy) : RedirectResponse
    {
        $vacancy->update([
            'title' => $request->title(),
            'description' => $request->description(),
            'sector_id' => $request->sectorId(),
            'type' => $request->type(),
            'vacancy_url' => $request->vacancyUrl() ?? $partner->referral_url,
        ]);

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function destroy(Partner $partner, Vacancy $vacancy) : RedirectResponse
    {
        $vacancy->delete();

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }
}
