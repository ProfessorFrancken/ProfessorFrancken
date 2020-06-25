<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\Http\Requests\FooterRequest;
use Francken\Extern\LogoUploader;
use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\Footer;

final class AdminFootersController
{
    /**
     * @var LogoUploader
     */
    private $uploader;

    public function __construct(LogoUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function create(Partner $partner)
    {
        return view('admin.extern.partners.sponsor-options.footer.create', [
            'partner' => $partner,
            'footer' => $partner->footer ?? new Footer(),
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'create'], ['partner' => $partner]), 'text' => 'Add footer logo'],
            ]
        ]);
    }

    public function store(FooterRequest $request, Partner $partner)
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:' . FooterRequest::MAX_FILE_SIZE],
        ]);

        $logo = $this->uploader->uploadFooterLogo($request->logo, $partner->name);
        $footer = new Footer([
            'is_enabled' => $request->isActive(),
            'referral_url' => $request->referralUrl(),
            'logo_media_id' => $logo->id,
        ]);

        $partner->footer()->save($footer);
        $footer->attachMedia($logo, Footer::PARTNER_FOOTER_LOGO_TAG);

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function edit(Partner $partner)
    {
        return view('admin.extern.partners.sponsor-options.footer.edit', [
            'partner' => $partner,
            'footer' => $partner->footer,
            'breadcrumbs' => [
                ['url' => action([AdminPartnersController::class, 'index']), 'text' => 'Partners'],
                ['url' => action([AdminPartnersController::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'edit'], ['partner' => $partner]), 'text' => 'Edit footer'],
            ]
        ]);
    }

    public function update(FooterRequest $request, Partner $partner)
    {
        $footer = $partner->footer;
        $logo = $this->uploader->uploadFooterLogo($request->logo, $partner->name);

        if ($logo !== null) {
            $footer->update(['logo_media_id' => $logo->id]);
            $footer->attachMedia($logo, Footer::PARTNER_FOOTER_LOGO_TAG);
        }

        $footer->update([
            'is_enabled' => $request->isActive(),
            'referral_url' => $request->referralUrl(),
        ]);

        return redirect()->action(
            [AdminPartnersController::class, 'show'],
            ['partner' => $partner]
        );
    }
}
