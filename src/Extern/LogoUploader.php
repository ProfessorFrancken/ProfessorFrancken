<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Http\UploadedFile;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

final class LogoUploader
{
    /**
     * @var MediaUploader
     */
    private $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadPrimaryLogo(?UploadedFile $logo, string $name) : ?Media
    {
        if ($logo === null) {
            return null;
        }

        $slug = str_slug($name);

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

        $slug = str_slug($name);

        return $this->uploader->fromSource($logo)
            ->toDirectory("images/partners/{$slug}/")
            ->useFilename("logo_footer_{$slug}")
            ->upload();
    }
}