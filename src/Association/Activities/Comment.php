<?php

declare(strict_types=1);

namespace Francken\Association\Activities;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Comment extends Model
{
    /**
     * @var string
     */
    protected $table = 'association_activities_comments';

    /**
     * @var string[]
     */
    protected $fillable = [
        'member_id',
        'content',
    ];

    protected $casts = [
        'member_id' => 'int',
        'activity_id' => 'int',
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
