<?php

declare(strict_types=1);

namespace Francken\Shared\Media\Http\Controllers;

use Francken\Shared\Media\Directory;
use Francken\Shared\Media\MediaPresenter;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\View\View;
use Plank\Mediable\Media;

final class MediaController
{
    /**
     * @var string
     */
    private const DISK = 'uploads';

    public function index(FilesystemManager $storage, string $directory = '') : View
    {
        /** @var \Illuminate\Pagination\LengthAwarePaginator $media */
        $media = Media::inDirectory(static::DISK, $directory)
               ->paginate(100);

        $media->transform(function (Media $media) : MediaPresenter {
            return new MediaPresenter($media);
        });

        return view('admin.compucie.media.index', [
            'media' => $media,
            'directories' => Directory::childDirectories($storage, $directory),
            'breadcrumbs' => $this->breadcrumbs($directory),
        ]);
    }

    public function show(Media $media) : View
    {
        $mediableTypes = \DB::table('mediables')
            ->where('media_id', $media->id)
            ->groupBy('mediable_type')
            ->select('mediable_type')
            ->get();

        $mediables = $mediableTypes->mapWithKeys(function ($type) use ($media) : array {
            return [
                $type->mediable_type =>
                $media->models($type->mediable_type)->get()
            ];
        });

        return view('admin.compucie.media.show', [
            'media' => new MediaPresenter($media),
            'mediables' => $mediables,
            'breadcrumbs' => array_merge(
                $this->breadcrumbs($media->directory),
                [['url' => action([static::class, 'show'], $media->id), 'text' => "{$media->basename}"]]
            ),
        ]);
    }

    private function breadcrumbs(string $directory) : array
    {
        $path = '';
        $breadcrumbs = collect(explode('/', $directory))->map(function ($directory, $key) use (&$path) : array {
            $path .= $directory . '/';

            return ['url' => action([static::class, 'index'], $path), 'text' => $directory];
        });
        $breadcrumbs->prepend(['url' => action([static::class, 'index']), 'text' => 'Media']);
        return $breadcrumbs->toArray();
    }
}
