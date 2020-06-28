<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

final class Committee extends Model
{
    protected $table = 'commissies';
    protected $connection = 'francken-legacy';
    protected $fillable = [
        'naam',
        'emailadres'
    ];

    public function members() : HasMany
    {
        return $this->hasMany(CommitteeMember::class, 'commissie_id');
    }

    public function getNameAttribute()
    {
        return $this->naam;
    }

    public function getEmailAttribute()
    {
        return $this->emailadres;
    }

    public function committeeMembers() : Collection
    {
        return $this->members->sortBy(function ($member) {
            return [
                $member->board_year,
                $member->member->full_name
            ];
        });
    }
}
