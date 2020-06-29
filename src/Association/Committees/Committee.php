<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Francken\Auth\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Plank\Mediable\Mediable;

final class Committee extends Model
{
    use Mediable;

    protected $table = 'association_committees';
    protected $fillable = [
        'board_id',
        'parent_committee_id',
        'logo_media_id',
        'photo_media_id',
        'name',
        'slug',
        'email',
        'is_public',

        'source_content',
        'compiled_content',
        'fallback_page',
    ];

    public function members() : HasMany
    {
        return $this->hasMany(CommitteeMember::class);
    }

    public function committeeMembers() : Collection
    {
        return $this->members->sortBy(function (CommitteeMember $member) : string {
            return $member->member->full_name;
        });
    }

    public function getRoleAttribute() : Role
    {
        return Role::fromCommittee($this);
    }

    public function getPermissionsAttribute() : Collection
    {
        return $this->role->permissions;
    }
}
