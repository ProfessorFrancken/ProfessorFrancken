<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Association\Photos\Http\Controllers\PhotosController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class FlickrAlbum extends Model
{
    /**
     * @var string
     */
    protected $table = 'albums';

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'published_at',
        'activity_date',
    ];

    public function photos() : HasMany
    {
        return $this->hasMany(FlickrPhoto::class, 'album_id')
            ->orderBy('taken_at')
            ->where('is_public', true);
    }

    public function coverPhoto() : HasOne
    {
        return $this->hasOne(FlickrPhoto::class, 'id', 'cover_photo')->withDefault(function ($x) {
            return $this->photos()->first()?->toArray() ?? [];
        });
    }

    public function nextAlbum() : ?self
    {
        /** @var FlickrAlbum|null $album */
        $album = self::orderBy('activity_date', 'asc')
            ->where('is_public', true)
            ->where('activity_date', '>', $this->activity_date)
            ->where('id', '!=', $this->id)
            ->with('coverPhoto')
            ->first();

        return $album;
    }

    public function previousAlbum() : ?self
    {
        /** @var FlickrAlbum|null $album */
        $album = self::orderBy('activity_date', 'asc')
            ->where('is_public', true)
            ->where('activity_date', '<', $this->activity_date)
            ->where('id', '!=', $this->id)
            ->with('coverPhoto')
            ->first();

        return $album;
    }

    public function url() : string
    {
        return action([PhotosController::class, 'show'], $this->slug);
    }

    public function addView() : void
    {
        $this->views += 1;
        $this->save();
    }
}
