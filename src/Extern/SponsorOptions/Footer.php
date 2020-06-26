<?php

declare(strict_types=1);

namespace Francken\Extern\SponsorOptions;

use Francken\Extern\Partner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Plank\Mediable\Mediable;

final class Footer extends Model
{
    use Mediable;

    public const PARTNER_FOOTER_LOGO_TAG = 'partner_footer_logo';

    protected $table = 'extern_partner_footers';
    protected $fillable = [
        'is_enabled',
        'referral_url',
        'logo_media_id',
    ];
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function partner() : BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function getLogoAttribute() : ?string
    {
        $photo = $this->getMedia(static::PARTNER_FOOTER_LOGO_TAG)->last();

        if ($photo !== null) {
            return $photo->getUrl();
        }

        return null;
    }

    public function scopeWithPhotos($query)
    {
        return $query->withMedia([static::PARTNER_FOOTER_LOGO_TAG]);
    }
}
