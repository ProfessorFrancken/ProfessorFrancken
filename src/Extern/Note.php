<?php

declare(strict_types=1);

namespace Francken\Extern;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Note extends Model
{
    /**
     * @var string
     */
    protected $table = 'extern_partner_notes';

    /**
     * @var string[]
     */
    protected $fillable = [
        'note',
        'member_id',
    ];

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }
}
