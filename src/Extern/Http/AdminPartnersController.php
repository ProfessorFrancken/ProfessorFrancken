<?php

declare(strict_types=1);

namespace Francken\Extern\Http;

use Francken\Extern\ContactDetails;
use Francken\Extern\Http\Requests\AdminSearchPartnersRequest;
use Francken\Extern\Http\Requests\ContactDetailsRequest;
use Francken\Extern\Http\Requests\PartnerRequest;
use Francken\Extern\LogoUploader;
use Francken\Extern\Partner;
use Francken\Extern\PartnerStatus;
use Francken\Extern\Sector;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminPartnersController
{
    /**
     * @var int
     */
    private const PARTNERS_PER_PAGE = 50;

    private LogoUploader $uploader;

    public function __construct(LogoUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index(AdminSearchPartnersRequest $request) : View
    {
        $partners = Partner::query()
            ->search($request)
            ->with([
                'sector',
                'logoMedia',
                'companyProfile',
                'footer',
            ])
            ->withCount([
                'vacancies'
            ])
            ->orderBy('name', 'ASC')
            ->paginate(self::PARTNERS_PER_PAGE);

        return view('admin.extern.partners.index')
            ->with([
                'request' => $request,
                'partners' => $partners,
                'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                    return [$sector->getKey() => $sector->name];
                })->prepend("All", 0),
                'statuses' => collect(PartnerStatus::all())->prepend("All", 0),
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Partners'],
                ]
            ]);
    }

    public function create() : View
    {
        return view('admin.extern.partners.create', [
            'partner' => new Partner(),
            'contactDetails' => new ContactDetails(),
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                return [$sector->getKey() => $sector->name];
            }),
            'statuses' => PartnerStatus::all(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Partners'],
                ['url' => action([static::class, 'create']), 'text' => 'Add a new partner'],
            ]
        ]);
    }

    public function store(PartnerRequest $request, ContactDetailsRequest $contactDetailsRequest) : RedirectResponse
    {
        $logo = $this->uploader->uploadPrimaryLogo($request->logo, $request->name());

        $partner = Partner::create([
            'name' => $request->name(),
            'slug' => $request->slug(),
            'sector_id' => $request->sectorId(),
            'status' => $request->status(),
            'homepage_url' => $request->homepageUrl(),
            'referral_url' => $request->referralUrl(),
            'last_contract_ends_at' => $request->lastContractEndsAt(),
        ]);

        if ($logo !== null) {
            $partner->update(['logo_media_id' => $logo->id]);
            $partner->attachMedia($logo, Partner::PARTNER_LOGO_TAG);
        }
        $partner->contactDetails()->save(
            $contactDetailsRequest->contactDetails()
        );

        return redirect()->action(
            [self::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function show(Partner $partner) : View
    {
        $partner->load([
            'contacts.photoMedia',
            'alumni.member',
            'notes.member',
        ]);

        return view('admin.extern.partners.show', [
            'partner' => $partner,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Partners'],
                ['url' => action([static::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
            ]
        ]);
    }

    public function edit(Partner $partner) : View
    {
        return view('admin.extern.partners.edit', [
            'partner' => $partner,
            'contactDetails' => $partner->contactDetails,
            'sectors' => Sector::all()->mapWithKeys(function (Sector $sector) : array {
                return [$sector->getKey() => $sector->name];
            }),
            'statuses' => PartnerStatus::all(),
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Partners'],
                ['url' => action([static::class, 'show'], ['partner' => $partner]), 'text' => $partner->name],
                ['url' => action([static::class, 'edit'], ['partner' => $partner]), 'text' => 'Edit'],
            ]
        ]);
    }

    public function update(PartnerRequest $request, ContactDetailsRequest $contactDetailsRequest, Partner $partner) : RedirectResponse
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
            'last_contract_ends_at' => $request->lastContractEndsAt(),
        ]);

        $partner->contactDetails()->update(
            $contactDetailsRequest->contactDetails()->toArray()
        );

        return redirect()->action(
            [self::class, 'show'],
            ['partner' => $partner]
        );
    }

    public function destroy(Partner $partner) : RedirectResponse
    {
        $partner->delete();

        return redirect()->action([self::class, 'index']);
    }
}
