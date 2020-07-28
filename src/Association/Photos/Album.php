<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Association\Photos\Http\Controllers\PhotosController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Album extends Model
{
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
        return $this->hasMany(Photo::class)
            ->where('is_public', true)
            ->orderBy('taken_at');
    }

    public function coverPhoto() : HasOne
    {
        return $this->hasOne(Photo::class, 'id', 'cover_photo');
    }

    public function nextAlbum() : ?self
    {
        /** @var Album|null $album */
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
        /** @var Album|null $album */
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
