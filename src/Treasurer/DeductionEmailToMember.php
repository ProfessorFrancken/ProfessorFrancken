<?php

declare(strict_types=1);

namespace Francken\Treasurer;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class DeductionEmailToMember extends Model
{
    protected $table = 'treasurer_deduction_email_to_members';
    protected $fillable = [
        'member_id',
        'description',
        'amount_in_cents',
        'contained_errors',
    ];

    public function getAmountAttribute()
    {
        return $this->amount_in_cents / 100;
    }
    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }

    public function deduction() : BelongsTo
    {
        return $this->belongsTo(DeductionEmail::class, 'deduction_email_id');
    }
}
