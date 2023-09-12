<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;

final class Photo extends Model
{
    use SoftDeletes;

    protected $table = 'association_photos';

    /**
     * @var string[]
     */
    protected $fillable = [
        'album_id',
        'name',
        'path',
        'visibility',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /** @return BelongsTo<Album, Photo> */
    public function album() : BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function src() : string
    {
        return action([\Francken\Association\Photos\Http\Controllers\PhotosController::class, 'showImage'], ['path' => $this->path]);
    }

    public function getIsTallAttribute() : bool
    {
        return false;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted() : void
    {
        static::addGlobalScope(new class() implements Scope {
            /**
             * Apply the scope to a given Eloquent query builder.
             * @param Builder<Photo> $builder
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
