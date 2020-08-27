<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class BorrelcieAccount extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'borrelcie_accounts';

    /**
     * @var string[]
     */
    protected $fillable = ['member_id'];

    protected $casts = [
        'member_id' => 'int'
    ];

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class);
    }
}
