<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CommitteeMember extends Model
{
    protected $table = 'commissie_lid';
    protected $connection = 'francken-legacy';
    protected $fillable = [
        'commissie_id',
        'lid_id',
        'jaar',
        'functie',
    ];
    protected $touches = ['committee'];

    public function committee() : BelongsTo
    {
        return $this->belongsTo(Committee::class, 'commissie_id');
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'lid_id');
    }

    public function getFuncationAttribute()
    {
        return $this->functie;
    }

    public function getBoardYearAttribute() : int
    {
        return (int)$this->jaar;
    }
}
