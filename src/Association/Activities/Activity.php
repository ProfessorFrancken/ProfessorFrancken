<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

final class Activity extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'association_activities';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'source_content',
        'compiled_content',
        'location',
        'start_date',
        'end_date',
        'google_calendar_uid',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getGoogleMapsEmbedUriAttribute() : string
    {
        return 'https://www.google.com/maps/embed/v1/place?' . http_build_query([
            'q' => $this->location,
            'zoom' => 13,
            'key' => 'AIzaSyBmxy9LR0IeIDPmfVY_2ZQOLSbgNz_jDpw'
        ]);
    }

    public function getRegistrationDeadlineAttribute() : Carbon
    {
        return $this->start_date;
    }
}
