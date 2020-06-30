<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Http\CommitteesController;
use Francken\Auth\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Plank\Mediable\Mediable;

final class Committee extends Model
{
    use Mediable;

    public const COMMIEE_LOGO_TAG = 'committee_logo';

    public const COMMITEE_PHOTO_TAG = 'committee_photo';

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

    public function id()
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function email() : string
    {
        return $this->email;
    }

    public function logo() : ?string
    {
        return '';
    }

    public function link() : string
    {
        return action(
            [CommitteesController::class, 'show'],
            [
                'board' => $this->board,
                'committee' => $this
            ]
        );
    }

    public function board() : BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function page() : string
    {
        return (is_null($this->fallback_page) || $this->fallback_page === '')
            ? 'committees.show'
            : $this->fallback_page;
    }
}
