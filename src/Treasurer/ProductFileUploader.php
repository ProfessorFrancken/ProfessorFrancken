<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Plank\Mediable\MediaUploader;

final class ProductFileUploader
{
    private MediaUploader $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadPhoto(?UploadedFile $photo, Product $product) : void
    {
        if ($photo === null) {
            return;
        }

        $slug = Str::slug($product->name);

        $photo = $this->uploader->fromSource($photo)
            ->toDirectory("images/consumption-counter/products/{$slug}/")
            ->useFilename("photo_{$slug}")
            ->upload();

        $product->update([
            'afbeelding' => $photo->getUrl()
        ]);
    }

    public function uploadSplashPhoto(?UploadedFile $splashPhoto, ProductExtra $productExtra) : void
    {
        if ($splashPhoto === null) {
            return;
        }

        $slug = Str::slug($productExtra->product->name);

        $splashPhoto = $this->uploader->fromSource($splashPhoto)
            ->toDirectory("images/consumption-counter/products/{$slug}/")
            ->useFilename("splashPhoto_{$slug}")
            ->upload();

        $productExtra->update([
            'splash_afbeelding' => $splashPhoto->getUrl()
        ]);
    }
}
