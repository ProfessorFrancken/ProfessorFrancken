<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\ContentCompiler;
use Francken\Extern\Http\Requests\CompanyProfileRequest;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Extern\Sector;
use Francken\Extern\SponsorOptions\CompanyProfile;

final class AdminCompanyProfilesController
{
    public function create(Partner $partner)
    {
        return view('admin.extern.partners.sponsor-options.company-profile.create', [
            'partner' => $partner,
            'profile' => $partner->companyProfile ?? new CompanyProfile(),
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) {
                return [$sector->id => $sector->name];
            }),
            'statuses' => PartnerStatus::all(),
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'create'], ['partner' => $partner]), 'text' => 'Add company profile'],
            ]
        ]);
    }

    public function store(CompanyProfileRequest $request, Partner $partner, ContentCompiler $compiler)
    {
        $markdown = $compiler->content($request->content());
        $partner->companyProfile()->save(
            new CompanyProfile([
                'is_enabled' => $request->isActive(),
                'source_content' => $markdown->originalMarkdown(),
                'compiled_content' => $markdown->compiledContent(),
            ])
        );

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function edit(Partner $partner)
    {
        return view('admin.extern.partners.sponsor-options.company-profile.edit', [
            'partner' => $partner,
            'profile' => $partner->companyProfile,
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) {
                return [$sector->id => $sector->name];
            }),
            'statuses' => PartnerStatus::all(),
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'edit'], ['partner' => $partner]), 'text' => 'Edit company profile'],
            ]
        ]);
    }

    public function update(CompanyProfileRequest $request, Partner $partner, ContentCompiler $compiler)
    {
        $markdown = $compiler->content($request->content());
        $partner->companyProfile()->update(
            [
                'is_enabled' => $request->isActive(),
                'source_content' => $markdown->originalMarkdown(),
                'compiled_content' => $markdown->compiledContent(),
            ]
        );

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }
}
