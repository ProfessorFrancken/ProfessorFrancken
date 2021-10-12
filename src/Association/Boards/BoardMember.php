<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeImmutable;
use Francken\Association\LegacyMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use Webmozart\Assert\Assert;

final class BoardMember extends Model
{
    use Mediable;

    /**
     * @var string
     */
    private const BOARD_MEMBER_PHOTO_TAG =  'board_member_photo';

    /**
     * @var string
     */
    protected $table = 'association_board_members';

    /**
     * @var string[]
     */
    protected $fillable = [
        'board_id',
        'member_id',
        'name',
        'title',

        'board_member_status',
        'installed_at',
        'demissioned_at',
        'decharged_at',

        'photo_media_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'member_id' => 'integer',
        'board_id' => 'integer',
        'installed_at' => 'date:Y-m-d',
        'demissioned_at' => 'date:Y-m-d',
        'decharged_at' => 'date:Y-m-d',
    ];

    /**
     * @var mixed[]
     */
    protected $dates = [
    ];

    public static function install(
        Board $board,
        int $memberId,
        string $title,
        DateTimeImmutable $installedAt,
        ?Media $photo
    ) : self {
        /** @var LegacyMember|null $legacyMember */
        $legacyMember = LegacyMember::find($memberId);
        $fullname = $legacyMember !== null
                  ? $legacyMember->fullname
                  : '';

        /** @var self $member */
        $member = $board->members()->make([
            'member_id' => $memberId,
            'name' => $fullname,
            'title' => $title,
            'installed_at' => $installedAt,
            'photo_media_id' => $photo->id ?? null,
        ]);
        Assert::isInstanceOf($member, self::class);

        $member->refreshStatus();

        if ($photo !== null) {
            $member->attachMedia($photo, static::BOARD_MEMBER_PHOTO_TAG);
        }


        return $member;
    }

    public function getPhotoAttribute() : ?string
    {
        $photo = $this->photoMedia;

        if ($photo !== null) {
            return $photo->getUrl();
        }

        return null;
    }

    public function board() : BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function member() : BelongsTo
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }

    public function getFullnameAttribute() : string
    {
        return optional($this->member)->fullname ?? 'Unkown member';
    }

    /**
     * We prefer to use this method to update the attributes of a board member
     * so that we can encapsulate changing a member's name based on their profile
     * and we can change the status of a member based on the stall, demissioned
     * and decharged dates
     */
    public function updateBoardMemberAttributes(
        int $memberId,
        string $title,
        DateTimeImmutable $installedAt,
        ?DateTimeImmutable $demissionedAt,
        ?DateTimeImmutable $dechargedAt,
        ?Media $photo
    ) : void {
        /** @var LegacyMember|null $legacyMember */
        $legacyMember = LegacyMember::find($memberId);
        $fullname = $legacyMember !== null
                  ? $legacyMember->fullname
                  : '';

        $this->member_id = $memberId;
        $this->name = $fullname;
        $this->title = $title;
        $this->installed_at = $installedAt;
        $this->demissioned_at = $demissionedAt;
        $this->decharged_at = $dechargedAt;
        $this->refreshStatus();

        if ($photo !== null) {
            $this->syncMedia($photo, static::BOARD_MEMBER_PHOTO_TAG);
            $this->photo_media_id = (int) $photo->id;
        }

        $this->save();
    }

    /**
     * Changes the status of the board member to their actual status
     * Will dispatch appropriate events and save the model if the stauts was changed.
     */
    public function refreshStatus() : void
    {
        $status = $this->actualBoardMemberStatus();

        // If the board member's status has changed then we will dispatch
        // appropriate events, otherwise we do nothing
        if ($status === $this->board_member_status) {
            return;
        }

        $this->board_member_status = $status;

        // Since this method is also called when intalling a member we will
        // have to save the model beforehand to guarantee that we he a valid id
        $this->save();

        if ($this->member_id === null) {
            return;
        }

        switch ($status) {
            case BoardMemberStatus::CANDIDATE:
                event(new MemberBecameCandidateBoardMember($this->board_id, $this->member_id));
                break;
            case BoardMemberStatus::BOARD_MEMBER:
                event(new BoardMemberWasInstalled($this->board_id, $this->member_id));
                break;
            case BoardMemberStatus::DEMISSIONED_BOARD_MEMBER:
                event(new BoardMemberWasDemissioned($this->board_id, $this->member_id));
                break;
            case BoardMemberStatus::DECHARGED_BOARD_MEMBER:
                event(new BoardMemberWasDischarged($this->board_id, $this->member_id));
                break;
        }
    }

    public function photoMedia() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'photo_media_id');
    }

    public function scopeWithPhotos(Builder $query) : Builder
    {
        return $query->withMedia([static::BOARD_MEMBER_PHOTO_TAG]);
    }

    /**
     * The actual member status might be different than the current status if
     * the demissioned at or decharged at dates have recently been changed
     */
    private function actualBoardMemberStatus() : string
    {
        return BoardMemberStatus::fromDates(
            new DateTimeImmutable(),
            DateTimeImmutable::createFromMutable($this->installed_at),
            $this->demissioned_at ? DateTimeImmutable::createFromMutable($this->demissioned_at) : null,
            $this->decharged_at ? DateTimeImmutable::createFromMutable($this->decharged_at) : null
        );
    }
}
