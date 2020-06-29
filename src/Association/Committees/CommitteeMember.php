<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CommitteeMember extends Model
{
    protected $table = 'association_committee_members';
    protected $fillable = [
        'committee_id',
        'member_id',
        'function',
        'installed_at',
        'decharged_at',
    ];
    protected $touches = ['committee'];
    protected $dates = [
        'installed_at',
        'decharged_at',
    ];

    public function committee() : BelongsTo
    {
        return $this->belongsTo(Committee::class, 'commissie_id');
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'lid_id');
    }

    public function getFunctionAttribute() : ?string
    {
        return $this->attributes['functie'] ?? null;
    }

    public function getBoardYearAttribute() : int
    {
        return (int)$this->attributes['jaar'];
    }
}
