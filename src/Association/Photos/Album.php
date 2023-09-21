<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
