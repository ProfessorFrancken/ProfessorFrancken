<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http\Controllers\Admin;

use Francken\Association\LegacyMember;
use Francken\Association\Members\Http\Requests\AdminConsumptionCounterSettingsRequest;
use Francken\Association\Members\Http\Requests\AdminMemberRequest;
use Francken\Shared\Http\Controllers\Controller;
use Francken\Treasurer\MemberExtra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Plank\Mediable\MediaUploader;
use Webmozart\Assert\Assert;

final class ConsumptionCounterSettingsController extends Controller
{
    public function edit(LegacyMember $member) : View
    {
        $consumptionCounterOptions = AdminMemberRequest::CONSUMPTION_COUNTER_OPTIONS;
        $consumptionCounterExtra = MemberExtra::query()->firstOrNew(['lid_id' => $member->id]);

        return view('admin.association.members.consumption-counter-settings.edit', [
            'member' => $member,
            'consumptionCounterOptions' => $consumptionCounterOptions,
            'consumptionCounterExtra' => $consumptionCounterExtra,

            'breadcrumbs' => [
                ['url' => action([MembersController::class, 'index']), 'text' => 'Members'],
                ['url' => action([MembersController::class, 'show'], ['member' => $member]), 'text' => $member->fullname],
                ['url' => action([self::class, 'edit'], ['member' => $member]), 'text' => 'Edit Consumption Counter settings'],
            ]
        ]);
    }

    public function update(AdminConsumptionCounterSettingsRequest $request, LegacyMember $member, MediaUploader $uploader) : RedirectResponse
    {
        $consumptionCounterExtra = MemberExtra::firstOrCreate(['lid_id' => $member->id]);
        $consumptionCounterExtra->update([
            'prominent' => $request->prominent(),
            'kleur' => $request->color(),
            'bijnaam' => $request->nickname(),
            'button_width' => $request->buttonWidth(),
            'button_height' => $request->buttonHeight(),
        ]);

        if ($request->hasFile(('image'))) {
            $this->uploadImage($uploader, $request->image, $consumptionCounterExtra);
        }

        return redirect()->action([MembersController::class, 'show'], ['member' => $member]);
    }

    private function uploadImage(MediaUploader $uploader, ?UploadedFile $photo, MemberExtra $consumptionCounterExtra) : void
    {
        if ($photo === null) {
            return;
        }

        Assert::notNull($consumptionCounterExtra->member);

        $slug = Str::slug($consumptionCounterExtra->member->fullname);

        $photo = $uploader->fromSource($photo)
            ->toDirectory("images/consumption-counter/members/{$slug}/")
            ->useFilename("image_{$slug}")
            ->upload();

        $consumptionCounterExtra->update([
            'afbeelding' => $photo->getUrl()
        ]);
    }
}
