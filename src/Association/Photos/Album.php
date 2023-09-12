<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Association\Photos\Http\Controllers\PhotosController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Scope;
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

    /**
     * The "booted" method of the model.
     */
    protected static function booted() : void
    {
        static::addGlobalScope(new class() implements Scope {
            /**
             * Apply the scope to a given Eloquent query builder.
             * @param Builder<Album> $builder
             */
            public function apply(
                Builder $builder,
                Model $model
            ) : void {
                $visibilities = [];
                if (Gate::allows('view-private-albums')) {
                    $visibilities[] = 'private';
                }
                if (Gate::allows('view-members-only-albums')) {
                    $visibilities[] = 'members-only';
                }
                if (Gate::allows('view-albums')) {
                    $visibilities[] = 'public';
                }


                $builder->whereIn('visibility', $visibilities);
            }
        });
    }
}
