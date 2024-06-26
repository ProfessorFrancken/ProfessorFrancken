<?php

declare(strict_types=1);

namespace Francken\Extern;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Alumnus extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'extern_partner_alumni';

    /**
     * @var string[]
     */
    protected $fillable = [
        'member_id',
        'position',
        'started_position_at',
        'stopped_position_at',
        'notes'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'member_id' => 'int',
        'started_position_at' => 'datetime:Y-m-d',
        'stopped_position_at' => 'datetime:Y-m-d',
    ];

    public function getFullnameAttribute() : string
    {
        return optional($this->member)->fullname ?? 'Unkown member';
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }

    /** @return BelongsTo<Partner, Alumnus> */
    public function partner() : BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
}
