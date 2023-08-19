<?php

declare(strict_types=1);

namespace Francken\Shared\Media;

use Francken\Shared\Media\Http\Controllers\MediaController;
use League\Flysystem\FilesystemException;
use Plank\Mediable\Media;

final class MediaPresenter
{
    private Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    public function iconClass() : string
    {
        $iconMap = [
            Media::TYPE_IMAGE => 'fas fa-file-image',
            Media::TYPE_IMAGE_VECTOR => 'fas fa-file-image',
            Media::TYPE_PDF => 'fas fa-file-pdf',
            Media::TYPE_AUDIO => 'fas fa-file-audio',
            Media::TYPE_ARCHIVE => 'fas fa-file-archive',
            Media::TYPE_DOCUMENT => 'fas fa-file-alt',
            Media::TYPE_SPREADSHEET => 'fas fa-file-excel',
            Media::TYPE_PRESENTATION => 'fas fa-file-presentation',
        ];

        return $iconMap[$this->media->aggregate_type] ?? 'fas fa-file';
    }

    public function mediaUrl() : string
    {
        return action([MediaController::class, 'show'], $this->media->id);
    }

    public function readableSize() : string
    {
        return $this->media->readableSize(1);
    }

    public function basename() : string|null
    {
        return $this->media->basename;
    }

    public function directory() : string|null
    {
        return $this->media->directory;
    }

    public function mimeType() : string|null
    {
        return $this->media->mime_type;
    }

    public function getUrl() : string
    {
        return $this->media->getUrl();
    }

    public function isImage() : bool
    {
        return in_array($this->media->aggregate_type, [
            Media::TYPE_IMAGE,
            Media::TYPE_IMAGE_VECTOR,
        ], true);
    }

    /**
     * Check if the file is located below the public webroot.
     */
    public function isPubliclyAccessible() : bool
    {
        try {
            return $this->media->isPubliclyAccessible();
        } catch (FilesystemException $e) {
            return false;
        }
    }
}
