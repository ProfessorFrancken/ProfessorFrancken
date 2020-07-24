<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CommitteeMember extends Model
{
    protected $casts = [
        'member_id' => 'int',
        'committee_id' => 'int',
        'installed_at' => 'datetime',
        'decharged_at' => 'datetime',
    ];

    /**
     * @var string
     */
    protected $table = 'association_committee_members';

    /**
     * @var string[]
     */
    protected $fillable = [
        'committee_id',
        'member_id',
        'function',
        'installed_at',
        'decharged_at',
    ];

    /**
     * @var string[]
     */
    protected $touches = ['committee'];

    /**
     * @var string[]
     */
    protected $dates = [
        'installed_at',
        'decharged_at',
    ];

    public function committee() : BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }
}
