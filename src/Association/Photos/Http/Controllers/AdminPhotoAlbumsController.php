<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Francken\Association\Photos\Album;
use Francken\Association\Photos\FlickrAlbum;
use Francken\Association\Photos\Http\Requests\AdminAlbumRequest;
use Francken\Association\Photos\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

final class AdminPhotoAlbumsController
{
    private const ROOT = 'remote.php/dav/files/compucie/';
    private const BASE_PATH = 'remote.php/dav/files/compucie/images';

    public function index() : View
    {
        $flickrAlbums = FlickrAlbum::query()
            ->orderBy('activity_date', 'desc')
            ->paginate(10, ['*'], 'flickr');

        $albums = Album::query()
            ->orderBy('published_at', 'desc')
            ->withCount('photos')
            ->paginate(10);

        return view('admin.association.photo-albums.index', [
            'albums' => $albums,
            'flickrAlbums' => $flickrAlbums,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
            ]
        ]);
    }

    public function create() : View
    {
        $album = new Album();

        $albumDirectories = $this->albumDirectories();


        return view('admin.association.photo-albums.create', [
            'album' => $album,
            'albumDirectories' => $albumDirectories,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
                ['url' => action([self::class, 'create']), 'text' => 'Create album'],
            ]
        ]);
    }

    public function show(Album $album) : View
    {
        $photos = $album->photos()->paginate(20);

        return view('admin.association.photo-albums.show', [
            'album' => $album,
            'photos' => $photos,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
                ['url' => action([self::class, 'show'], ['album' => $album]), 'text' => $album->title]
            ]
        ]);
    }

    public function edit(Album $album) : View
    {
        $albumDirectories = $this->albumDirectories();

        return view('admin.association.photo-albums.edit', [
            'album' => $album,
            'albumDirectories' => $albumDirectories,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
                ['url' => action([self::class, 'show'], ['album' => $album]), 'text' => $album->title],
                ['url' => action([self::class, 'edit'], ['album' => $album]), 'text' => 'Edit'],
            ]
        ]);
    }

    public function store(AdminAlbumRequest $request) : RedirectResponse
    {
        $files = collect(\Storage::disk('nextcloud')->files("images/{$request->path()}"));
        $photos = $files->map(fn ($file) => new Photo([
            'name' => pathinfo($file, PATHINFO_FILENAME),
            'path' => str_replace(self::BASE_PATH, '', $file),
            'visibility' => $request->visibility(),
        ]));

        $album = Album::create([
            'title' => $request->title(),
            'description' => $request->description(),
            'slug' => $request->slug(),
            'published_at' => $request->publishedAt(),
            'visibility' => $request->visibility(),

            'disk' => $request->disk(),
            'path' => $request->path(),
        ]);
        $album->photos()->saveMany($photos);

        return redirect()->action([self::class, 'show'], ['album' => $album]);
    }

    public function refresh() : RedirectResponse
    {
        Artisan::queue('photos:synchronize');

        return redirect()->action([self::class, 'index']);
    }

    public function update(AdminAlbumRequest $request, Album $album) : RedirectResponse
    {
        $album->update([
            'title' => $request->title(),
            'description' => $request->description(),
            'visibility' => $request->visibility(),
            'published_at' => $request->publishedAt(),
            'path' => $request->path(),
        ]);

        return redirect()->action([self::class, 'show'], ['album' => $album]);
    }

    /** @return Collection<string, string> */
    private function albumDirectories() : Collection
    {
        return collect(\Storage::disk('nextcloud')->directories("images/albums"))
                          ->filter(fn (string $album) => $album === str_replace(' ', '', $album))
                          ->map(fn (string $f) : string => str_replace(self::ROOT, '', $f))
                          ->map(fn (string $f) : string => preg_replace("/^images\//", '/', $f) ?? '')
                          ->mapWithKeys(fn (string $f) => [$f => $f]);
    }
}
