<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use Illuminate\Database\Eloquent\Model;

final class EarnedAdtchievement extends Model
{
    // protected $with = ['pirate', 'pirateCrew', 'adtchievement'];
    protected $table = 'lustrum_pirate_adtchievements';
    protected $fillable = [
        'points',
        'pirate_crew_id',
        'reason',
        'created_at',
        'updated_at',
    ];

    public function adtchievement()
    {
        return $this->belongsTo(Adtchievement::class);
    }

    public function pirate()
    {
        return $this->belongsTo(Pirate::class);
    }

    public function pirateCrew()
    {
        return $this->belongsTo(PirateCrew::class);
    }
}
