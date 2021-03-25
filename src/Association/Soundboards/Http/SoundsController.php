<?php

declare(strict_types=1);

namespace Francken\Association\Soundboards\Http;

use Francken\Association\Soundboards\FileUploader;
use Francken\Association\Soundboards\Http\Requests\SoundRequest;
use Francken\Association\Soundboards\Sound;
use Francken\Association\Soundboards\Soundboard;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class SoundsController
{
    public function store(SoundRequest $request, FileUploader $uploader, Soundboard $soundboard) : RedirectResponse
    {
        $sound = $soundboard->sounds()->make([
            'name' => $request->name(),
            'css_background' => $request->cssBackground(),
            'css_foreground' => $request->cssForeground(),
            'uploaded_by_member_id' => $request->uploadedByMemberId(),
        ]);

        $uploader->uploadAudio($request->audio, $sound);
        $uploader->uploadImage($request->image, $sound);

        return redirect()->action([SoundboardsController::class, 'show'], ['soundboard' => $soundboard]);
    }

    public function edit(Soundboard $soundboard, Sound $sound) : View
    {
        return view('association.soundboards.sounds.edit', [
            'sound' => $sound,
            'soundboard' => $soundboard,
            'breadcrumbs' => [
                ['url' => '/association/', 'text' => 'Association'],
                ['url' => action([SoundboardsController::class, 'index']), 'text' => 'Soundboards'],
                ['url' => action([SoundboardsController::class, 'show'], ['soundboard' => $soundboard]), 'text' => $soundboard->name],
            ],
        ]);
    }

    public function update(SoundRequest $request, FileUploader $uploader, Soundboard $soundboard, Sound $sound) : RedirectResponse
    {
        $sound->update([
            'name' => $request->name(),
            'css_background' => $request->cssBackground(),
            'css_foreground' => $request->cssForeground(),
        ]);

        if ($request->hasFile('audio')) {
            $uploader->uploadAudio($request->audio, $sound);
        }

        if ($request->hasFile('image')) {
            $uploader->uploadImage($request->image, $sound);
        }

        return redirect()->action([SoundboardsController::class, 'show'], ['soundboard' => $soundboard]);
    }

    public function destroy(Soundboard $soundboard, Sound $sound) : RedirectResponse
    {
        $sound->delete();

        return redirect()->action([SoundboardsController::class, 'show'], ['soundboard' => $soundboard]);
    }
}
