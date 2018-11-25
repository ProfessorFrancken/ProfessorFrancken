<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Database\Eloquent\Model;

final class Album extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'published_at',
        'activity_date',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class)
            ->where('is_public', true)
            ->orderBy('taken_at');
    }

    public function coverPhoto()
    {
        return $this->hasOne(Photo::class, 'id', 'cover_photo');
    }

    public function nextAlbum()
    {
        return self::orderBy('activity_date', 'asc')
            ->where('is_public', true)
            ->where('activity_date', '>', $this->activity_date)
            ->where('id', '!=', $this->id)
            ->with('coverPhoto')
            ->first();
    }

    public function previousAlbum()
    {
        return self::orderBy('activity_date', 'desc')
            ->where('is_public', true)
            ->where('activity_date', '<', $this->activity_date)
            ->where('id', '!=', $this->id)
            ->with('coverPhoto')
            ->first();
    }

    public function url()
    {
        return action([PhotosController::class, 'show'], $this->slug);
    }

    public function addView() : void
    {
        $this->views += 1;
        $this->save();
    }
}
