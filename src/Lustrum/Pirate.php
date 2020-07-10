<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Webmozart\Assert\Assert;

/**
 * Francken\Lustrum\Pirate
 *
 * @property int $id
 * @property int $member_id
 * @property int $pirate_crew_id
 * @property string $name
 * @property string $title
 * @property int $earned_points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read PirateCrew $crew
 * @property-read Collection|EarnedAdtchievement[] $earnedAdtchievements
 * @property-read int|null $earned_adtchievements_count
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate whereEarnedPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate wherePirateCrewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Francken\Lustrum\Pirate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Pirate extends Model
{
    /**
     * @var string
     */
    protected $table = 'lustrum_pirates';

    /**
     * @var string[]
     */
    protected $fillable = [
        'pirate_crew_id',
        'member_id',
        'name',
        'earned_points',
        'title'
    ];

    public static function initiate(LegacyMember $member) : self
    {
        /** @var Pirate $pirate */
        $pirate = self::create([
            'member_id' => $member->id,
            'name' => $member->fullname,
            'earned_points' => 0,
            'title' => 'Noobie'
        ]);

        Assert::isInstanceOf($pirate, self::class);

        return $pirate;
    }

    public function joinCrew(PirateCrew $crew) : void
    {
        $this->crew()->associate($crew);
    }

    public function claimPoints(int $amount, string $reason) : void
    {
    }

    // Claim achievement
    // Claim points


    public function crew() : BelongsTo
    {
        return $this->belongsTo(PirateCrew::class, 'pirate_crew_id');
    }

    public function earnedAdtchievements() : HasMany
    {
        return $this->hasMany(EarnedAdtchievement::class, 'pirate_id');
    }
}
