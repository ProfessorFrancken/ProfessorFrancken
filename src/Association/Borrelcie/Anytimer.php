<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Anytimer extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'borrelcie_anytimers';

    /**
     * @var string[]
     */
    protected $fillable = [
        'drinker_id',
        'owner_id',
        'accepted',
        'amount',
        'reason',
        'context',
    ];

    protected $casts = [
        'owner_id' => 'int',
        'drinker_id' => 'int',
        'amount' => 'int',
        'accepted' => 'boolean',
    ];

    public function drinker() : BelongsTo
    {
        return $this->belongsTo(BorrelcieAccount::class);
    }

    public function owner() : BelongsTo
    {
        return $this->belongsTo(BorrelcieAccount::class);
    }

    public function scopeActiveClaimedAnytimers(Builder $query, BorrelcieAccount $account) : Builder
    {
        return $query
            ->activeAnytimers()
            ->where('owner_id', $account->getKey())
            ->groupBy('drinker_id');
    }

    public function scopeActiveGivenAnytimers(Builder $query, BorrelcieAccount $account) : Builder
    {
        return $query
            ->activeAnytimers()
            ->where('drinker_id', $account->getKey())
            ->groupBy('owner_id');
    }

    public function scopeActiveAnytimers(Builder $query) : Builder
    {
        return $query->select(['drinker_id', 'owner_id'])
            ->selectRaw("sum(case when (context = 'given' and accepted) or (context = 'claimed' and accepted) or (context = 'used') or (context = 'drank' and accepted) then amount end) as count_active");
    }
}
