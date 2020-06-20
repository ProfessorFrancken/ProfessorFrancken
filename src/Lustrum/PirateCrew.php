<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use DateTimeImmutable;
use DB;
use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;

final class PirateCrew extends Model
{
    protected $table = 'lustrum_pirate_crews';

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'total_points',
        'pirate_crew_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function crewMembers()
    {
        return $this->hasMany(Pirate::class, 'pirate_crew_id');
    }

    public function earnedAdtchievements()
    {
        return $this->hasMany(EarnedAdtchievement::class, 'pirate_crew_id');
    }

    public function initiate(LegacyMember $member)
    {
        return $this->crewMembers()->create([
            'member_id' => $member->id,
            'name' => $member->full_name,
            'earned_points' => 0,
            'title' => 'Noobie',
        ]);
    }

    public function total_earned_adtchievements()
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

        $adtchievement = $this->earnedAdtchievements()
           ->groupBy('lustrum_pirate_adtchievements.pirate_id')
           // ->where('lustrum_pirate_adtchievements.created_at', $today)
           ->select([
               'pirate_id',
               DB::raw('lustrum_pirate_adtchievements.points as total_points'),
           ])
           ->orderBy('total_points')
            ->first();

        if ($adtchievement !== null) {
            return $adtchievement->pirate;
        }
        return null;

        return $this->earnedAdtchievements()
            ->where('lustrum_pirate_adtchievements.created_at', $today);
    }
}
