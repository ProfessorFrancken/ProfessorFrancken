<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webmozart\Assert\Assert;

final class SignUp extends Model
{
    /**
     * @var string
     */
    protected $table = 'association_activities_sign_ups';

    /**
     * @var string[]
     */
    protected $fillable = [
        'member_id',
        'plus_ones',
        'dietary_wishes',
        'has_drivers_license',
        'discount',
        'notes',
    ];

    protected $casts = [
        'member_id' => 'int',
        'activity_id' => 'int',
        'plus_ones' => 'int',
        'has_drivers_license' => 'boolean',
        'discount' => 'int',
    ];

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class)->withTrashed();
    }

    public function activity() : BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function getCostsAttribute() : int
    {
        Assert::notNull($this->activity);
        Assert::notNull($this->activity->signUpSettings);

        $activityCostsPerPerson = $this->activity->signUpSettings->costs_per_person;

        return (int)($activityCostsPerPerson * (1 + $this->plus_ones) - $this->discount);
    }

    public function getExportNameAttribute() : string
    {
        Assert::notNull($this->member);

        return collect([
                $this->member->achternaam,
                $this->member->voornaam,
                $this->member->tussenvoegsel
            ])
                ->filter()
                ->implode(' ');
    }
}
