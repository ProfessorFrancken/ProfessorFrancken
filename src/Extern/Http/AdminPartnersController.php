<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\Http\Requests\PartnerRequest;
use Francken\Extern\LogoUploader;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Extern\Sector;

final class AdminPartnersController
{
    /**
     * @var LogoUploader
     */
    private $uploader;

    public function __construct(LogoUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        return view('admin.extern.partners.index')
            ->with([
                'partners' => Partner::paginate(),
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Partners'],
                ]
            ]);
    }

    public function create()
    {
        return view('admin.extern.partners.create', [
            'partner' => new Partner(),
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) {
                return [$sector->id => $sector->name];
            }),
            'statuses' => PartnerStatus::all(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Partners'],
                ['url' => action([static::class, 'create']), 'text' => 'Add a new partner'],
            ]
        ]);
    }

    public function store(PartnerRequest $request)
    {
        $logo = $this->uploader->uploadPrimaryLogo($request->logo, $request->name());

        $partner = Partner::create([
            'name' => $request->name(),
            'slug' => $request->slug(),
            'sector_id' => $request->sectorId(),
            'status' => $request->status(),
            'homepage_url' => $request->homepageUrl(),
            'referral_url' => $request->referralUrl(),
            'logo_media_id' => $logo->id
        ]);
        $partner->attachMedia($logo, Partner::PARTNER_LOGO_TAG);

        return redirect()->action(
            [self::class, 'show'],
            ['partner' => $partner->id]
        );
    }

    public function show(Partner $partner)
    {
        return view('admin.extern.partners.show', [
            'partner' => $partner,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Partners'],
                ['url' => action([static::class, 'show'], ['partner' => $partner->id]), 'text' => $partner->name],
            ]
        ]);
    }

    public function edit(Partner $partner)
    {
        return view('admin.extern.partners.edit', [
            'partner' => $partner,
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) {
                return [$sector->id => $sector->name];
            }),
            'statuses' => PartnerStatus::all(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Partners'],
                ['url' => action([static::class, 'edit'], ['partner' => $partner->id]), 'text' => $partner->name . ' / Edit'],
            ]
        ]);
    }

    public function update(PartnerRequest $request, Partner $partner)
    {
        $logo = $this->uploader->uploadPrimaryLogo($request->logo, $request->name());

        if ($logo !== null) {
            $partner->syncMedia($logo, Partner::PARTNER_LOGO_TAG);
            $partner->logo_media_id = $logo->id;
        }

        $partner->update([
            'name' => $request->name(),
            'slug' => $request->slug(),
            'sector_id' => $request->sectorId(),
            'status' => $request->status(),
            'homepage_url' => $request->homepageUrl(),
            'referral_url' => $request->referralUrl(),
        ]);

        return redirect()->action(
            [self::class, 'show'],
            ['partner' => $partner->id]
        );
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->action([self::class, 'index']);
    }
}
