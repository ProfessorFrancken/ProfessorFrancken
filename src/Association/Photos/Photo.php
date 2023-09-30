<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Association\Photos\Http\Controllers\PhotosController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'taken_at',
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
        return action(
            [PhotosController::class, 'showImage'],
            ['album' => $this->album_id, 'photo' => $this]
        );
    }

    public function srcset() : string
    {
        return $this->src();
    }

    public function getIsTallAttribute() : bool
    {
        return false;
    }

    public function getFlickrBaseUrlAttribute() : string
    {
        return $this->src();
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
