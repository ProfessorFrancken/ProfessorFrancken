<?php

declare(strict_types=1);

namespace Francken\Extern\SponsorOptions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Vacancy extends Model
{
    protected $table = 'extern_partner_vacancies';
    protected $fillable = [
        'title',
        'description',
        'sector_id',
        'type',
        'vacancy_url',
    ];

    public function partner() : BelongsTo
    {
        return $this->belongsTo(self::class);
    }
}

