<?php

declare(strict_types=1);

namespace Francken\Extern\SponsorOptions;

use Francken\Extern\Partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

final class Footer extends Model
{
    use Mediable;

    /**
     * @var string
     */
    public const PARTNER_FOOTER_LOGO_TAG = 'partner_footer_logo';

    /**
     * @var string
     */
    protected $table = 'extern_partner_footers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'is_enabled',
        'referral_url',
        'logo_media_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function partner() : BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function getLogoAttribute() : ?string
    {
        $logo = $this->logoMedia;

        if ($logo !== null) {
            return $logo->getUrl();
        }

        return null;
    }

    public function logoMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'logo_media_id');
    }

    public function scopeWithPhotos(Builder $query) : Builder
    {
        return $query->withMedia([static::PARTNER_FOOTER_LOGO_TAG]);
    }
}
