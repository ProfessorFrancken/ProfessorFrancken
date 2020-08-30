<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->belongsTo(LegacyMember::class);
    }

    public function activity() : BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
