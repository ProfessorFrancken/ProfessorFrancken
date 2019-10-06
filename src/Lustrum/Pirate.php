<?php

declare(strict_types=1);

namespace Francken\Lustrum;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;

final class Pirate extends Model
{
    protected $table = 'lustrum_pirates';

    protected $fillable = [
        'pirate_crew_id',
        'member_id',
        'name',
        'earned_points',
        'title'
    ];

    public static function initiate(LegacyMember $member)
    {
        return self::create([
            'member_id' => $member->id,
            'name' => $member->full_name,
            'earned_points' => 0,
            'title' => 'Noobie'
        ]);
    }

    public function joinCrew(PirateCrew $crew)
    {
        return $this->crew()->associate($crew);
    }

    public function claimPoints(int $amount, string $reason) : void
    {
    }

    // Claim achievement
    // Claim points


    public function crew()
    {
        return $this->belongsTo(PirateCrew::class, 'pirate_crew_id');
    }

    public function earnedAdtchievements()
    {
        return $this->hasMany(EarnedAdtchievement::class, 'pirate_id');
    }
}
