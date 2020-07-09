<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Http\UploadedFile;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;
use Str;

final class LogoUploader
{
    private MediaUploader $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadPrimaryLogo(?UploadedFile $logo, string $name) : ?Media
    {
        if ($logo === null) {
            return null;
        }

        $slug = Str::slug($name);

        return $this->uploader->fromSource($logo)
            ->toDirectory("images/partners/{$slug}/")
            ->useFilename("logo_{$slug}")
            ->upload();
    }

    public function uploadFooterLogo(?UploadedFile $logo, string $name) : ?Media
    {
        if ($logo === null) {
            return null;
        }

        $slug = Str::slug($name);

        return $this->uploader->fromSource($logo)
            ->toDirectory("images/partners/{$slug}/")
            ->useFilename("logo_footer_{$slug}")
            ->upload();
    }

    public function uploadContactPhoto(?UploadedFile $photo, Partner $partner, Contact $contact) : ?Media
    {
        if ($photo === null) {
            return null;
        }

        $partnerSlug = Str::slug($partner->name);
        $contactSlug = Str::slug($contact->fullname);

        return $this->uploader->fromSource($photo)
            ->toDirectory("images/partners/{$partnerSlug}/contacts/")
            ->useFilename("contact_{$contactSlug}")
            ->upload();
    }
}
