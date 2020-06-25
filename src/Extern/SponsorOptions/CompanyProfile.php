<?php

declare(strict_types=1);

namespace Francken\Extern\SponsorOptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CompanyProfile extends Model
{
    protected $table = 'extern_partner_company_profiles';
    protected $fillable = [
        'is_enabled',
        'source_content',
        'compiled_content',
    ];
    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    public function partner() : BelongsTo
    {
        return $this->belongsTo(self::class);
    }
}
