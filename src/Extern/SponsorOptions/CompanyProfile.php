<?php

declare(strict_types=1);

namespace Francken\Extern\SponsorOptions;

use Francken\Extern\Partner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CompanyProfile extends Model
{
    protected $table = 'extern_partner_company_profiles';
    protected $fillable = [
        'display_name',
        'is_enabled',
        'source_content',
        'compiled_content',
    ];
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function partner() : BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function getDisplayNameAttribute() : string
    {
        $displayName = $this->attributes['display_name'] ?? null;

        if ($displayName !== null && $displayName !== '') {
            return $displayName;
        }

        return $this->partner->name ?? '';
    }
}
