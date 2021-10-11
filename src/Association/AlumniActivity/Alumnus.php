<?php

declare(strict_types=1);

namespace Francken\Association\AlumniActivity;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Alumnus extends Model
{
    /**
     * @var string
     */
    protected $table = 'association_alumni_activity_2022_alumni';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'member_id',
        'fullname',
        'study',
        'graduation_year'
    ];

    protected $casts = [
        'member_id' => 'int',
        'graduation_year' => 'int',
    ];

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class)->withTrashed();
    }
}
