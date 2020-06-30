<?php

declare(strict_types=1);

namespace Francken\Association\Committees;

use Francken\Association\Boards\Board;
use Francken\Auth\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Plank\Mediable\Media;
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


    public function getLogoAttribute() : ?string
    {
        $logo = $this->logoMedia;

        if ($logo !== null) {
            return $logo->getUrl();
        }

        return null;
    }

    public function logoMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'logo_media_id');
    }

    public function getPhotoAttribute() : ?string
    {
        $photo = $this->photoMedia;

        if ($photo !== null) {
            return $photo->getUrl();
        }

        return null;
    }

    public function photoMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'photo_media_id');
    }

    public function members() : HasMany
    {
        return $this->hasMany(CommitteeMember::class);
    }

    public function parentCommittee() : BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_committee_id');
    }

    public function childCommittee() : HasOne
    {
        return $this->hasOne(self::class, 'parent_committee_id');
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

    public function board() : BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function getPageAttribute() : string
    {
        return (is_null($this->fallback_page) || $this->fallback_page === '')
            ? 'committees.show'
            : $this->fallback_page;
    }
}
