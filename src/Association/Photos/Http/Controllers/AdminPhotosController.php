<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\Album;
use Francken\Association\Photos\Http\Requests\AdminPhotoRequest;
use Francken\Association\Photos\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class AdminPhotosController
{
    public function edit(Album $album, Photo $photo) : View
    {
        return view('admin.association.photo-albums.photos.edit', [
            'album' => $album,
            'photo' => $photo,
            'breadcrumbs' => [
                ['url' => action([AdminPhotoAlbumsController::class, 'index']), 'text' => 'Photo albums'],
                ['url' => action([AdminPhotoAlbumsController::class, 'show'], ['album' => $album]), 'text' => $album->title],
                ['url' => action([self::class, 'edit'], ['album' => $album, 'photo' => $photo]), 'text' => "Photos / {$photo->name} / Edit"],
            ]
        ]);
    }

    public function update(AdminPhotoRequest $request, Album $album, Photo $photo) : RedirectResponse
    {
        $photo->update([
            'name' => $request->name(),
            'visibility' => $request->visibility(),
        ]);
        // TODO

        return redirect()->action([AdminPhotoAlbumsController::class, 'show'], ['album' => $album]);
    }
}
