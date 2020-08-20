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
use Webmozart\Assert\Assert;

final class Committee extends Model
{
    use Mediable;

    /**
     * @var string
     */
    public const COMMITTEE_LOGO_TAG = 'committee_logo';

    /**
     * @var string
     */
    public const COMMITEE_PHOTO_TAG = 'committee_photo';

    /**
     * @var string
     */

    protected $table = 'association_committees';
    /**
     * @var string[]
     */
    protected $fillable = [
        'board_id',
        'parent_committee_id',
        'logo_media_id',
        'photo_media_id',
        'name',
        'goal',
        'slug',
        'email',
        'is_public',

        'source_content',
        'compiled_content',
        'fallback_page',
    ];

    public static function continueFrom(self $previousCommittee, Board $toBoardYear) : self
    {
        /** @var array<string, mixed> $previousCommitteeAttributes*/
        $previousCommitteeAttributes = $previousCommittee->toArray();

        /** @var Committee $committee */
        $committee = self::create(
            array_merge(
                $previousCommitteeAttributes,
                [
                    'board_id' => $toBoardYear->id,
                    'parent_committee_id' => $previousCommittee->getKey(),
                ]
            )
        );

        Assert::isInstanceOf($committee, self::class);

        if ($previousCommittee->logoMedia !== null) {
            $committee->attachmedia($previousCommittee->logoMedia, self::COMMITTEE_LOGO_TAG);
        }
        if ($previousCommittee->photoMedia !== null) {
            $committee->attachmedia($previousCommittee->photoMedia, self::COMMITEE_PHOTO_TAG);
        }

        return $committee;
    }

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

    public function getSuggestedCommitteeMembersAttribute() : Collection
    {
        return CommitteeMember::with('member')
            ->where('committee_id', '=', $this->parent_committee_id)
            ->whereNotIn('member_id', $this->members->pluck('member_id'))
            ->get();
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
            return optional($member->member)->fullname ?? '';
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
        return ($this->fallback_page === null || $this->fallback_page === '')
            ? 'committees.show'
            : $this->fallback_page;
    }
}
