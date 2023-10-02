<?php

declare(strict_types=1);

namespace Francken\Extern\SponsorOptions;

use Francken\Extern\Partner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;

final class FccFooter extends Model
{
    use Mediable;

    /**
     * @var string
     */
    public const PARTNER_FOOTER_LOGO_TAG = 'partner_fcc_footer_logo';

    /**
     * @var string
     */
    protected $table = 'extern_partner_fcc_footers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'is_enabled',
        'logo_media_id',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /** @return BelongsTo<Partner, FccFooter> */
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

    /** @return BelongsTo<Media, FccFooter> */
    public function logoMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'logo_media_id');
    }
}
