<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class EarnedAdtchievement extends Model
{
    /**
     * @var string
     */
    protected $table = 'lustrum_pirate_adtchievements';

    /**
     * @var string[]
     */
    protected $fillable = [
        'points',
        'pirate_crew_id',
        'reason',
        'created_at',
        'updated_at',
    ];

    public function adtchievement() : BelongsTo
    {
        return $this->belongsTo(Adtchievement::class);
    }

    public function pirate() : BelongsTo
    {
        return $this->belongsTo(Pirate::class);
    }

    public function pirateCrew() : BelongsTo
    {
        return $this->belongsTo(PirateCrew::class);
    }
}
