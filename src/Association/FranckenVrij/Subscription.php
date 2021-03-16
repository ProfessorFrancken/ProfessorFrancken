<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij;

use DateTimeImmutable;
use Illuminate\Database\Eloquent\Model;

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
}
