<?php

declare(strict_types=1);

namespace Francken\Association\Soundboards;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Plank\Mediable\MediaUploader;

final class FileUploader
{
    private MediaUploader $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadAudio(?UploadedFile $audio, Sound $sound) : void
    {
        $soundboard = $sound->soundboard;

        if ($audio === null || $soundboard === null) {
            return;
        }

        $slug = Str::slug($sound->name);

        $audio = $this->uploader->fromSource($audio)
            ->toDirectory("association/soundboards/{$soundboard->id}/sounds/{$slug}/")
            ->useFilename("audio_{$slug}")
            ->upload();

        $sound->audio_media_id = (int) $audio->id;
        $sound->save();
        $sound->attachmedia($audio, Sound::SOUND_AUDIO_TAG);
    }

    public function uploadImage(?UploadedFile $image, Sound $sound) : void
    {
        $soundboard = $sound->soundboard;

        if ($image === null || $soundboard === null) {
            return;
        }

        $slug = Str::slug($sound->name);

        $image = $this->uploader->fromSource($image)
            ->toDirectory("association/soundboards/{$soundboard->id}/sounds/{$slug}/")
            ->useFilename("image_{$slug}")
            ->upload();

        $sound->image_media_id = (int) $image->id;
        $sound->save();
        $sound->attachmedia($image, Sound::SOUND_IMAGE_TAG);
    }
}
