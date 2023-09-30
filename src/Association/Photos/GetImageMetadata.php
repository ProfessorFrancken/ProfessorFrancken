<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use DateTimeImmutable;
use DateTimeInterface;
use Intervention\Image\Facades\Image;
use PHPExif\Adapter\Exiftool;
use PHPExif\Reader\Reader;

class GetImageMetadata
{
    private Reader $reader;

    public function __construct()
    {
        $adapter = new Exiftool(['toolPath'  => base_path('vendor/phpexiftool/exiftool/exiftool')]);
        $this->reader = new Reader($adapter);
    }

    public function metadata(string $path) : ImageMetadata
    {
        $creationDate = null;
        try {
            $datetime = $this->reader->read($path)->getCreationDate();

            if ($datetime instanceof DateTimeInterface) {
                $creationDate = DateTimeImmutable::createFromMutable($datetime);
            }
        } catch (\Throwable $e) {
            // igore
        }

        $image  = Image::make($path);
        $width = $image->width();
        $height = $image->height();

        return new ImageMetadata($creationDate, $width, $height);
    }
}
