<?php

declare(strict_types=1);

namespace Francken\Association\Photos\Http\Controllers;

use Exception;
use Francken\Association\Photos\Album;
use Francken\Association\Photos\FlickrAlbum;
use Francken\Association\Photos\Http\Requests\AdminAlbumRequest;
use Francken\Association\Photos\Photo;
use Francken\Shared\Clock\Clock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

final class AdminPhotoAlbumsController
{
    private const ROOT = 'remote.php/dav/files/compucie/';

    public function index(Clock $clock) : View
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
            'year' => $clock->now()->format('Y'),
            'flickrAlbums' => $flickrAlbums,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
            ]
        ]);
    }

    public function create(Request $request, Clock $clock) : View
    {
        $year = $request->string('year')->toString();

        if ($year === '') {
            $year = $clock->now()->format('Y');
        }

        $albumDirectories = $this->albumDirectories($year);

        if ($albumDirectories->isEmpty()) {
            return view('admin.association.photo-albums.create-empty', [
                'year' => $year,
                'breadcrumbs' => [
                    ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
                    ['url' => action([self::class, 'create'], ['year' => $year]), 'text' => "{$year} / Create album"],
                ]
            ]);
        }

        return view('admin.association.photo-albums.create', [
            'album' => new Album(),
            'albumDirectories' => $albumDirectories,
            'year' => $year,
            'breadcrumbs' => [
                ['url' => action([self::class, 'index']), 'text' => 'Photo albums'],
                ['url' => action([self::class, 'create'], ['year' => $year]), 'text' => "{$year} / Create album"],
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
        return view('admin.association.photo-albums.edit', [
            'album' => $album,
            'year' => $album->published_at->format('Y'),
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
            'path' => preg_replace(
                "/^images\//",
                '/',
                str_replace(self::ROOT, '', $file)
            ),
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
            'slug' => $request->slug(),
            'description' => $request->description(),
            'visibility' => $request->visibility(),
            'published_at' => $request->publishedAt(),
            'path' => $request->path(),
        ]);

        if ($request->updateVisibilityOfAllPhotos()) {
            $album->photos()->update([
                'visibility' => $request->visibility()
            ]);
        }

        return redirect()->action([self::class, 'show'], ['album' => $album]);
    }

    public function destroy(Album $album) : RedirectResponse
    {
        $album->delete();

        return redirect()->action([self::class, 'index']);
    }

    public function refreshAlbum(Album $album) : RedirectResponse
    {
        $album->load('photos');

        $files = collect(Storage::disk('nextcloud')->files("images/{$album->path}"));
        $photos = $files->map(fn ($file) => new Photo([
            'name' => pathinfo($file, PATHINFO_FILENAME),
            'path' => preg_replace(
                "/^images\//",
                '/',
                str_replace(self::ROOT, '', $file)
            ),
            'visibility' => $album->visibility,
        ]));

        $newPhotos = $photos->filter(function (Photo $photo) use ($album) {
            return ! $album->photos->contains(function (Photo $albumPhoto) use ($photo) {
                return $albumPhoto->path === $photo->path;
            });
        });
        $album->photos()->saveMany($newPhotos);

        return redirect()->action([self::class, 'show'], ['album' => $album]);
    }

    /** @return Collection<string, string> */
    private function albumDirectories(string $year) : Collection
    {
        try {
            $directories = Storage::disk('nextcloud')->directories("images/albums/{$year}/");

            $albumsForTheSelectedYear = Album::query()->whereYear('published_at', $year)->pluck('path');

            $directories = collect($directories)
                ->filter(fn (string $album) => $album === str_replace(' ', '', $album))
                ->map(fn (string $directory) : string => str_replace(self::ROOT, '', $directory))
                ->map(fn (string $directory) : string => preg_replace("/^images\//", '/', $directory) ?? '')
                ->reject(fn (string $directory) => $albumsForTheSelectedYear->contains($directory));

            return $directories->mapWithKeys(fn (string $f) => [$f => $f]);
        } catch (Exception) {
            // If the d
            return collect();
        }
    }
}
