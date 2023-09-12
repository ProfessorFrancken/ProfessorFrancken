<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Association\Photos\Http\Controllers\PhotosController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Album extends Model
{
    use SoftDeletes;

    protected $table = 'association_albums';

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'published_at',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'published_at',
        'visibility',

        'slug',
        'disk',
        'path',
    ];

    /** @return HasMany<Photo> */
    public function photos() : HasMany
    {
        return $this->hasMany(Photo::class);
    }

    /** @return HasOne<Photo> */
    public function coverPhoto() : HasOne
    {
        return $this->hasOne(Photo::class)->oldestOfMany();
    }

    public function nextAlbum() : ?self
    {
        /** @var Album|null $album */
        $album = self::query()
            ->orderBy('published_at', 'asc')
            ->where('published_at', '>', $this->published_at)
            ->where('id', '!=', $this->id)
            ->with('coverPhoto')
            ->first();

        return $album;
    }

    public function previousAlbum() : ?self
    {
        /** @var Album|null $album */
        $album = self::query()
            ->orderBy('published_at', 'desc')
            ->where('published_at', '<', $this->published_at)
            ->where('id', '!=', $this->id)
            ->with('coverPhoto')
            ->first();

        return $album;
    }

    public function url() : string
    {
        return action([PhotosController::class, 'show'], $this->slug);
    }

    public function nextcloudUrl() : string
    {
        return config('francken.general.nextcloud_host') . "/apps/files/?dir=/images/{$this->path}";
    }

    public function addView() : void
    {
        // Faking this impelementation for now
    }
}
