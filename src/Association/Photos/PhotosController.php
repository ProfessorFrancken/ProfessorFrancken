<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

final class PhotosController
{
    private const PHOTOS_PER_PAGE = 40;

    public function index()
    {
        $albums = Album::where('is_public', true)
            ->with('coverPhoto')
            ->orderBy('activity_date', 'desc')
            ->simplePaginate(16);

        return view('association.photos.index', ['albums' => $albums]);
    }

    public function show(string $album_slug)
    {
        $album = Album::where('slug', $album_slug)
            ->where('is_public', true)
            ->with('photos')
            ->first();

        if ( ! request()->has('page')) {
            $album->addView();
        }

        return view('association.photos.show', [
            'album' => $album,
            'photos' => $album->photos()->simplePaginate(self::PHOTOS_PER_PAGE),

            'cover_photo' => $album->coverPhoto,
            'next_album' => $album->nextAlbum(),
            'previous_album' => $album->previousAlbum(),
            'breadcrumbs' => [
                ['url' => '/association/photos', 'text' => 'Photos'],
                ['text' => $album->title],
            ]
        ]);
    }
}
