<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsTo(Album::class);
    }

    public function src() : string
    {
        return action([\Francken\Association\Photos\Http\Controllers\PhotosController::class, 'showImage'], ['path' => $this->path]);
    }

    public function getIsTallAttribute() : bool
    {
        return false;
    }
}
