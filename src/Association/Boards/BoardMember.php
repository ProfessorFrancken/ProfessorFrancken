<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Model;

final class BoardMember extends Model
{
    protected $table = 'association_board_members';

    protected $fillable = [
        'board_id',
        'member_id',
        'name',
        'title',
        'photo',

        'installed_at',
        'demisioned_at',
// demissionary
        'decharged_at',
    ];

    public function member()
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }

    public function getFullNameAttribute()
    {
        return $this->member->full_name;
    }
}
