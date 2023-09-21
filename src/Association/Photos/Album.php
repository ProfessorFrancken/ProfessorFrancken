<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;

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

    public function nextcloudUrl() : string
    {
        return config('francken.general.nextcloud_host') . "/apps/files/?dir=/images/{$this->path}";
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted() : void
    {
        static::addGlobalScope(
            'view-permission',
            function (Builder $builder) : void {
                $visibilities = ['public'];

                if (Gate::allows('view-private-albums')) {
                    $visibilities[] = 'private';
                }
                if (Gate::allows('view-members-only-albums')) {
                    $visibilities[] = 'members-only';
                }

                $builder->whereIn('visibility', $visibilities);
            }
        );
    }
}
