<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AdminAlbumCoverController
{
    public function update(Request $request, Album $album) : RedirectResponse
    {
        $album->update([
            'cover_photo_id' => $request->integer('cover_photo_id'),
        ]);

        return redirect()->action([AdminPhotoAlbumsController::class, 'show'], ['album' => $album]);
    }
}
