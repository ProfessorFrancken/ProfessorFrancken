<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * Francken\Association\Photos\Photo
 *
 * @property int $id
 * @property string $album_id
 * @property string|null $title
 * @property string|null $description
 * @property int $is_public
 * @property int $views
 * @property string $flickr_base_url
 * @property string $flickr_original_url
 * @property int $is_tall
 * @property int $is_wide
 * @property string $taken_at
 * @property int $latitude
 * @property int $longitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Album $album
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereFlickrBaseUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereFlickrOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereIsTall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereIsWide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereTakenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Association\Photos\Photo whereViews($value)
 * @mixin \Eloquent
 */
final class Photo extends Model
{
    private const SIZES = [
        75 => "_s",
        150 => "_q",
        240 => "_m",
        320 => "_n",
        640 => "_z",
        800 => "_c",
        1024 => "_b",
    ];

    public function album() : BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function src(int $quality = 1024) : string
    {
        $baseUrl = Str::before($this->flickr_base_url, '.jpg');

        return sprintf(
            "%s%s.jpg",
            $baseUrl,
            self::SIZES[$quality]
        );
    }

    /**
     * Get a srcset so that browsers can choose a src based on device width
     */
    public function srcset(float $divider = 2.0) : string
    {
        $baseUrl = Str::before($this->flickr_base_url, '.jpg');

        // Give a list of srces
        return collect(self::SIZES)
            ->map(fn ($value, $key) : string => sprintf(
                "%s%s.jpg %sw",
                $baseUrl,
                $value,
                round($key * 1.5)
            ))
            ->implode(', ');
    }
}
