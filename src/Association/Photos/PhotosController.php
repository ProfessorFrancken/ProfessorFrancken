<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

final class PhotosController
{
    private const PHOTOS_PER_PAGE = 40;

    public function index(AlbumsRepository $albums)
    {
        $albums = $albums->albums();

        return view('association.photos.index', ['albums' => $albums]);
    }

    public function show(AlbumsRepository $albums, string $album_slug)
    {
        $album = $albums->bySlug($album_slug);

        if ( ! request()->has('page')) {
            $album->addView();
        }

        return view('association.photos.show', [
            'album' => $album,
            'photos' => $album->photos()->simplePaginate(self::PHOTOS_PER_PAGE),

            'cover_photo' => $album->coverPhoto,
            'next_album' => $album->nextAlbum(),
            'previous_album' => $album->previousAlbum(),
        ]);
    }
}
