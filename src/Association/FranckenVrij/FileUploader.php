<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Imagick;
use Plank\Mediable\Media;
use Plank\Mediable\MediaUploader;

final class FileUploader
{
    /**
     * @var int
     */
    private const ONE_HUNDRED_MB = 100 * 1024 * 1024;

    private MediaUploader $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadPdf(Request $request, Edition $edition) : void
    {
        /** @var Media */
        $franckenVrijMedia = $this->uploader->fromSource($request->file('pdf'))
            ->toDirectory('francken-vrij')
            ->useFilename($edition->volume . '-' . $edition->edition)
            ->setMaximumSize(self::ONE_HUNDRED_MB)
            ->upload();

        $coverMedia = $this->generateCoverMedia(
            $request,
            $edition,
            $franckenVrijMedia
        );

        $edition->cover = $coverMedia->getUrl();
        $edition->pdf = $franckenVrijMedia->getUrl();
    }

    private function generateCoverMedia(
        Request $request,
        Edition $edition,
        Media $franckenVrijMedia
    ) : Media {
        /** @var string|UploadedFile */
        $coverFile = $request->hasFile('cover')
            ? $request->file('cover')
            : $this->generateCoverImageFromPdf(
                $franckenVrijMedia->getAbsolutePath()
            );

        return $this->uploader->fromSource($coverFile)
            ->toDirectory('francken-vrij/covers/')
            ->useFilename($edition->volume . '-' . $edition->edition . '-cover')
            ->setMaximumSize(self::ONE_HUNDRED_MB)
            ->upload();
    }

    private function generateCoverImageFromPdf(string $pdfPath) : ?string
    {
        $coverPath = preg_replace('"\.pdf$"', '-cover.png', $pdfPath);

        if ($coverPath === null) {
            return null;
        }

        $imagick = new Imagick();
        $imagick->setCompressionQuality(100);
        $imagick->setResolution(300, 300);
        $imagick->readImage($pdfPath . '[0]');
        $imagick->resizeImage(175, 245, Imagick::FILTER_LANCZOS, 0.9);
        $imagick->transformImageColorspace(Imagick::COLORSPACE_SRGB);
        $imagick->setFormat('png');
        $imagick->writeImage($coverPath);

        return $coverPath;
    }
}
