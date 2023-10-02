<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\Http\Requests\FccFooterRequest;
use Francken\Extern\LogoUploader;
use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\FccFooter;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class AdminFccFootersController
{
    private LogoUploader $uploader;

    public function __construct(LogoUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function create(Partner $partner) : View
    {
        return view('admin.extern.partners.sponsor-options.fcc-footer.create', [
            'partner' => $partner,
            'footer' => $partner->fccFooter ?? new FccFooter(),
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'create'], ['partner' => $partner]), 'text' => 'Add fcc footer logo'],
            ]
        ]);
    }

    public function store(FccFooterRequest $request, Partner $partner) : RedirectResponse
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:' . FccFooterRequest::MAX_FILE_SIZE],
        ]);

        $logo = $this->uploader->uploadFccFooterLogo($request->logo(), $partner->name);
        Assert::notNull($logo);

        $footer = new FccFooter([
            'is_enabled' => $request->isActive(),
            'logo_media_id' => $logo->id,
        ]);

        $partner->fccFooter()->save($footer);
        $footer->attachMedia($logo, FccFooter::PARTNER_FOOTER_LOGO_TAG);

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function edit(Partner $partner) : View
    {
        return view('admin.extern.partners.sponsor-options.fcc-footer.edit', [
            'partner' => $partner,
            'footer' => $partner->fccFooter,
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'edit'], ['partner' => $partner]), 'text' => 'Edit fcc footer'],
            ]
        ]);
    }

    public function update(FccFooterRequest $request, Partner $partner) : RedirectResponse
    {
        $footer = $partner->fccFooter;
        Assert::notNull($footer);

        $logo = $this->uploader->uploadFccFooterLogo($request->logo(), $partner->name);

        if ($logo !== null) {
            $footer->update(['logo_media_id' => $logo->id]);
            $footer->attachMedia($logo, FccFooter::PARTNER_FOOTER_LOGO_TAG);
        }

        $footer->update([
            'is_enabled' => $request->isActive(),
        ]);

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }
}
