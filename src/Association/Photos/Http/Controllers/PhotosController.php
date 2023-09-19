<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\Album;
use Francken\Association\Photos\AlbumsRepository;
use Francken\Association\Photos\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Webmozart\Assert\Assert;

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

    public function showImage(Album $album, Photo $photo) : StreamedResponse
    {
        $response = $this->streamedResponse($photo->path);
        $this->applyCache($response, $photo->path);

        return $response;
    }

    private function streamedResponse(string $path) : StreamedResponse
    {
        return Storage::disk('nextcloud')->download("images/{$path}");
    }

    private function applyCache(StreamedResponse $response, string $path) : void
    {
        $etag = Storage::disk('nextcloud')->checksum("images/{$path}");
        $response->setEtag($path);
        $response->setCache([
           'etag' => $etag,
           'public' => true,
        ]);
    }
}
