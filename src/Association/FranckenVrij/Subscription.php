<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Subscription extends Model
{
    /**
     * @var string
     */
    protected $table = 'association_francken_vrij_subscriptions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'member_id',
        'subscription_ends_at',
        'send_expiration_notification',
        'notified_at'
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'notified_at' => 'datetime',
        'send_expiration_notification' => 'boolean'
    ];

    public function isActiveAt(DateTimeImmutable $time) : bool
    {
        return $this->subscription_ends_at !== null && $this->subscription_ends_at > $time;
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class);
    }

    public function scopeWithActiveSubscription(Builder $query, DateTimeImmutable $at) : Builder
    {
        return $query->whereDate('subscription_ends_at', '>', $at);
    }

    public function scopeWithRecentlyExpiredSubscription(Builder $query, DateTimeImmutable $at) : Builder
    {
        return $query->whereDate('subscription_ends_at', '>', $at->modify('-1 year'))
            ->whereDate('subscription_ends_at', '<', $at);
    }

    public function scopeWithExpiredSubscription(Builder $query, DateTimeImmutable $at) : Builder
    {
        return $query->whereDate('subscription_ends_at', '<', $at);
    }

    public function scopeWithSoonToBeExpried(Builder $query, DateTimeImmutable $at) : Builder
    {
        return $query->whereDate('subscription_ends_at', '>', $at)
            ->whereDate('subscription_ends_at', '<', $at->modify('+1 year'));
    }
}
