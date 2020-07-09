<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Adtchievement extends Model
{
    /**
     * @var string
     */
    protected $table = 'lustrum_adtchievements';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'past_tense',
        'points',
        'is_repeatable',
        'is_team_effort',
        'is_hidden',
    ];

    protected $casts = [
        'is_team_effort' => 'bool',
        'is_repeatable' => 'bool',
        'is_hidden' => 'bool',
        'points' => 'int',
    ];

    public function earnBy(Pirate $pirate, ?int $points = null, string $reason = '') : void
    {
        // TODO:
        // Based on this adtchievement's settings eck if the pirate is allowed to earn this adtchievemnet
        if ($points === null) {
            $points = $this->points;
        }

        $this->earnedBy()
            ->attach(
                $pirate->id,
                [
                    'points' => $points,
                    'pirate_crew_id' => $pirate->pirate_crew_id,
                    'reason' => $reason,
                    'created_at' => new DateTimeImmutable(),
                    'updated_at' => new DateTimeImmutable(),
                ]
            );
    }

    public function earnedBy() : BelongsToMany
    {
        return $this->belongsToMany(Pirate::class, 'lustrum_pirate_adtchievements')
            ->withPivot(['pirate_crew_id']);
    }

    public function scopeEarnedByPirateCrew($builder, PirateCrew $crew) : BelongsToMany
    {
        return $this->earnedBy()
            ->where('lustrum_pirate_adtchievements.pirate_crew_id', $crew->id);
    }

    public function totalEarnedPointsBy(PirateCrew $crew) : int
    {
        return (int) $this->earnedByPirateCrew($crew)->sum('lustrum_pirate_adtchievements.points');
    }

    public function isHiddenForCrew(PirateCrew $crew) : bool
    {
        if ( ! $this->is_hidden) {
            return false;
        }

        $pirates = $this->earnedByPirateCrew($crew);

        return $pirates->count() === 0;
    }

    public function listEarnersOfCrew(PirateCrew $crew) : string
    {
        $pirates = $this->earnedByPirateCrew($crew)->get();

        return $pirates->groupBy(function ($pirate) {
            return $pirate->member_id;
        })->map(function ($pirates) {
            $pirate = $pirates->first();

            $count = $pirates->count();
            if ($count > 1) {
                return "{$pirate->name} ({$count}x)";
            }

            return $pirate->name;
        })->implode(', ');
    }
}
