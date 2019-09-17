<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Association\Photos\Http\Controllers\PhotosController;
use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Association\Photos\Album
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon $activity_date
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property int $is_public
 * @property int $is_prominent
 * @property string $cover_photo
 * @property int $views
 * @property int $amount_of_photos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Francken\Association\Photos\Photo $coverPhoto
 * @property-read \Illuminate\Database\Eloquent\Collection|\Francken\Association\Photos\Photo[] $photos
 * @property-read int|null $photos_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereActivityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereAmountOfPhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereCoverPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereIsProminent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Album whereViews($value)
 * @mixin \Eloquent
 */
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
