<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Lustrum\EarnedAdtchievement
 *
 * @property int $id
 * @property int $adtchievement_id
 * @property int $pirate_crew_id
 * @property int $pirate_id
 * @property int $points
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Francken\Lustrum\Adtchievement $adtchievement
 * @property-read \Francken\Lustrum\Pirate $pirate
 * @property-read \Francken\Lustrum\PirateCrew $pirateCrew
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement whereAdtchievementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement wherePirateCrewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement wherePirateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\EarnedAdtchievement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class EarnedAdtchievement extends Model
{
    protected $table = 'lustrum_pirate_adtchievements';

    protected $fillable = [
        'points',
        'pirate_crew_id',
        'reason',
        'created_at',
        'updated_at',
    ];

    public function adtchievement(): BelongsTo
    {
        return $this->belongsTo(Adtchievement::class);
    }

    public function pirate(): BelongsTo
    {
        return $this->belongsTo(Pirate::class);
    }

    public function pirateCrew(): BelongsTo
    {
        return $this->belongsTo(PirateCrew::class);
    }
}
