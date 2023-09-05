<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\FlickrAlbum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

final class AdminPhotoAlbumsController
{
    public function index() : View
    {
        $albums = FlickrAlbum::query()
            ->orderBy('activity_date', 'desc')
            ->paginate(40);

        return view('admin.association.photo-albums.index', [
            'albums' => $albums,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
            ]
        ]);
    }

    public function refresh() : RedirectResponse
    {
        Artisan::queue('photos:synchronize');

        return redirect()->action([self::class, 'index']);
    }
}
