<?php

declare(strict_types=1);

namespace Francken\Shared\Media;

use Francken\Shared\Media\Http\Controllers\MediaController;
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
        switch ($this->media->aggregate_type) {
            case Media::TYPE_IMAGE:
            case Media::TYPE_IMAGE_VECTOR:
                return 'fas fa-file-image';
            case Media::TYPE_PDF:
                return 'fas fa-file-pdf';
            case Media::TYPE_AUDIO:
                return 'fas fa-file-audio';
            case Media::TYPE_ARCHIVE:
                return 'fas fa-file-archive';
            case Media::TYPE_DOCUMENT:
                return 'fas fa-file-alt';
            case Media::TYPE_SPREADSHEET:
                return 'fas fa-file-excel';
            case Media::TYPE_PRESENTATION:
                return 'fas fa-file-presentation';
            case Media::TYPE_OTHER:
            case Media::TYPE_ALL:
            default:
                return 'fas fa-file';
        }
    }

    public function mediaUrl() : string
    {
        return action([MediaController::class, 'show'], $this->media->id);
    }

    public function readableSize() : string
    {
        return $this->media->readableSize(1);
    }

    public function basename() : string
    {
        return $this->media->basename;
    }
}
