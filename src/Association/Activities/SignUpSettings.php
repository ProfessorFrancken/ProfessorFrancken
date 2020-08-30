<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Illuminate\Database\Eloquent\Model;

final class SignUpSettings extends Model
{
    /**
     * @var string
     */
    protected $table = 'association_activities_sign_up_settings';

    /**
     * @var string[]
     */
    protected $fillable = [
        'activity_id',
        'max_sign_ups',
        'deadline_at',
        'costs_per_person',
        'max_plus_ones_per_member',
        'ask_for_dietary_wishes',
        'ask_for_drivers_license',
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
        'max_sign_ups' => 'int',
        'costs_per_person' => 'int',
        'max_plus_ones_per_member' => 'int',
        'ask_for_dietary_wishes' => 'boolean',
        'ask_for_drivers_license' => 'boolean',
    ];

    public function getIsFreeAttribute() : bool
    {
        return $this->costs_per_person === 0;
    }

    public function getAllowsPlusOnesAttribute() : bool
    {
        return $this->max_plus_ones_per_member === null ||
            $this->max_plus_ones_per_member > 0;
    }
}
