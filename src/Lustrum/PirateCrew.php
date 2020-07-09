<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use DateTimeImmutable;
use DB;
use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class PirateCrew extends Model
{
    /**
     * @var string
     */
    protected $table = 'lustrum_pirate_crews';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'total_points',
        'pirate_crew_id'
    ];

    public function getRouteKeyName() : string
    {
        return 'slug';
    }

    public function crewMembers() : HasMany
    {
        return $this->hasMany(Pirate::class, 'pirate_crew_id');
    }

    public function earnedAdtchievements() : HasMany
    {
        return $this->hasMany(EarnedAdtchievement::class, 'pirate_crew_id');
    }

    public function initiate(LegacyMember $member) : Pirate
    {
        return $this->crewMembers()->create([
            'member_id' => $member->id,
            'name' => $member->full_name,
            'earned_points' => 0,
            'title' => 'Noobie',
        ]);
    }

    public function total_earned_adtchievements() : int
    {
        return $this->earnedAdtchievements()
            ->count(\DB::raw('DISTINCT adtchievement_id'));
    }

    public function getTotalPointsAttribute() : int
    {
        return (int) $this->earnedAdtchievements()
            ->sum('lustrum_pirate_adtchievements.points');
    }

    public function getPirateOfTheDayAttribute() : ?Pirate
    {
        $today = new DateTimeImmutable();
        $adtchievement = EarnedAdtchievement::query()
            ->where('pirate_crew_id', $this->id)
            ->groupBy('lustrum_pirate_adtchievements.pirate_id')
            ->select([
                'pirate_id',
                DB::raw('sum(lustrum_pirate_adtchievements.points) as total_points'),
            ])
            ->orderBy('total_points', 'DESC')
            ->first();

        if ($adtchievement !== null) {
            return $adtchievement->pirate;
        }

        return null;
    }
}
