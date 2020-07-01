<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Illuminate\Http\UploadedFile;
use Plank\Mediable\MediaUploader;

final class FileUploader
{
    /**
     * @var MediaUploader
     */
    private $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadLogo(?UploadedFile $logo, Committee $committee) : void
    {
        if ($logo === null) {
            return;
        }

        $slug = str_slug($committee->name);

        $logo = $this->uploader->fromSource($logo)
            ->toDirectory("images/association/committees/{$slug}/")
            ->useFilename("logo_{$slug}")
            ->upload();

        if ($logo !== null) {
            $committee->update(['logo_media_id' => $logo->id]);
            $committee->attachmedia($logo, Committee::COMMITTEE_LOGO_TAG);
        }
    }

    public function uploadPhoto(?UploadedFile $photo, Committee $committee) : void
    {
        if ($photo === null) {
            return;
        }

        $slug = str_slug($committee->name);

        $photo = $this->uploader->fromSource($photo)
            ->toDirectory("images/association/committees/{$slug}/")
            ->useFilename("photo_{$slug}")
            ->upload();

        if ($photo !== null) {
            $committee->update(['photo_media_id' => $photo->id]);
            $committee->attachmedia($photo, Committee::COMMITEE_PHOTO_TAG);
        }
    }
}
