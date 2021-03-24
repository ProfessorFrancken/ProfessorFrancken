<?php

declare(strict_types=1);

namespace Francken\Association\Soundboards\Http;

use Francken\Association\Soundboards\FileUploader;
use Francken\Association\Soundboards\Soundboard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class SoundsController
{
    public function store(Request $request, FileUploader $uploader, Soundboard $soundboard) : RedirectResponse
    {
        $sound = $soundboard->sounds()->make([
                'name' => $request->input('name'),
                'css_background' => $request->input('css_background'),
                'css_foreground' => $request->input('css_foreground'),
                'uploaded_by_member_id' => $request->user()->member_id,
            ]);

        $uploader->uploadAudio($request->audio, $sound);
        $uploader->uploadImage($request->image, $sound);

        return redirect()->action([SoundboardsController::class, 'show'], ['soundboard' => $soundboard]);
    }
}
