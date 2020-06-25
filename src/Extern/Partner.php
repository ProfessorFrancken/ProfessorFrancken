<?php

declare(strict_types=1);

namespace Francken\Extern;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

final class Partner extends Model
{
    use SoftDeletes;
    use Mediable;

    public const PARTNER_LOGO_TAG = 'partner_logo';

    protected $table = 'extern_partners';
    protected $fillable = [
        'name',
        'sector_id',
        'logo_media_id',
        'homepage_url',
        'referral_url',
        'slug',
        'status',
    ];

    public function getLogoAttribute() : ?string
    {
        $photo = $this->getMedia(static::PARTNER_LOGO_TAG)->first();

        if ($photo !== null) {
            return $photo->getUrl();
        }

        return null;
    }

    public function scopeWithPhotos($query)
    {
        return $query->withMedia([static::PARTNER_LOGO_TAG]);
    }

    public function sector() : BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
