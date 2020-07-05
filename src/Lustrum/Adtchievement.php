<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * Francken\Lustrum\Adtchievement
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $past_tense
 * @property int $points
 * @property int $is_repeatable
 * @property int $is_team_effort
 * @property int $is_hidden
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Francken\Lustrum\Pirate[] $earnedBy
 * @property-read int|null $earned_by_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement earnedByPirateCrew(\Francken\Lustrum\PirateCrew $crew)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereIsRepeatable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereIsTeamEffort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement wherePastTense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Adtchievement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Adtchievement extends Model
{
    protected $table = 'lustrum_adtchievements';

    protected $fillable = [
        'title',
        'description',
        'past_tense',
        'points',
        'is_repeatable',
        'is_team_effort',
        'is_hidden',
    ];

    public function earnBy(Pirate $pirate, ?int $points = null, string $reason = ''): void
    {
        // TODO:
        // Based on this adtchievement's settings eck if the pirate is allowed to earn this adtchievemnet
        if ($points === null) {
            $points = $this->points;
        }

        return $this->earnedBy()
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

    public function earnedBy(): BelongsToMany
    {
        return $this->belongsToMany(Pirate::class, 'lustrum_pirate_adtchievements')
            ->withPivot(['pirate_crew_id']);
    }

    public function scopeEarnedByPirateCrew($builder, PirateCrew $crew): BelongsToMany
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
        if ( $this->is_hidden === 0) {
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
