<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\JobType;
use Francken\Extern\Partner;
use Francken\Extern\Sector;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

final class CompaniesController
{
    public function index() : View
    {
        $partners = Partner::query()
            ->orderBy('name', 'asc')
            ->whereHas('companyProfile', function (Builder $query) : void {
                $query->where('is_enabled', true);
            })
            ->with(['logoMedia'])
            ->get();

        $keywords = $partners->map(function ($partner): string {
            /** @var Partner $partner */
            return $partner->name;
        })->implode(', ');

        return view('career.companies.index')
            ->with([
                'partners' => $partners,
            'keywords' => $keywords,
                'breadcrumbs' => [
                    ['url' => '/career', 'text' => 'Career'],
                    ['url' => action([self::class, 'index']), 'text' => 'Company profiles'],
                ],
            ]);
    }

    public function show(Partner $partner) : View
    {
        $this->assertPartnerHasPublicProfile($partner);

        $partners = Partner::query()
            ->whereHas('companyProfile', function (Builder $query) : void {
                $query->where('is_enabled', true);
            })
            ->with(['logoMedia'])
            ->get();


        return view('career.companies.show')
            ->with([
                'partners' => $partners,
                'partner' => $partner,
                'sectors' => Sector::all()->mapWithKeys(fn (Sector $sector) : array => [$sector->name => $sector->icon]),
                'types' => JobType::TYPES,
                'breadcrumbs' => [
                    ['url' => '/career', 'text' => 'Career'],
                    ['url' => action([self::class, 'index']), 'text' => 'Company profiles'],
                    ['text' => $partner->name],
                ]
            ]);
    }

    private function assertPartnerHasPublicProfile(Partner $partner) : void
    {
        if ($partner->companyProfile === null || ! $partner->companyProfile->is_enabled) {
            abort(404);
        }
    }
}
