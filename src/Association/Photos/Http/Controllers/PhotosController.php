<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\AlbumsRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PhotosController
{
    /**
     * @var int
     */
    private const PHOTOS_PER_PAGE = 40;
    
    private AlbumsRepository $albums;

    public function __construct(AlbumsRepository $albums)
    {
        $this->albums = $albums;
    }

    public function index() : View
    {
        $albums = $this->albums->albums();

        return view('association.photos.index', ['albums' => $albums]);
    }

    public function show(string $albumSlug, Request $request) : View
    {
        $album = $this->albums->bySlug($albumSlug);

        if ( ! $request->has('page')) {
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
