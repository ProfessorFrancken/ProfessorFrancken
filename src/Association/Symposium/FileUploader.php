<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

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

    public function uploadLogo(?UploadedFile $logo, Symposium $symposium) : void
    {
        if ($logo === null) {
            return;
        }

        $slug = Str::slug($symposium->name);

        $logo = $this->uploader->fromSource($logo)
            ->toDirectory("images/association/symposiums/{$slug}/")
            ->useFilename("logo_{$slug}")
            ->upload();

        $symposium->update(['logo_media_id' => $logo->id]);
        $symposium->attachmedia($logo, Symposium::SYMPOSIUM_LOGO_TAG);
    }
}
