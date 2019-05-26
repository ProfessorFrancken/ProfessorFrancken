<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use DateTimeImmutable;
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

        'board_member_status',
        'installed_at',
        'demissioned_at',
        'decharged_at',
    ];

    protected $casts = [
        'board_id' => 'integer',
        'installed_at' => 'date:Y-m-d',
        'demissioned_at' => 'date:Y-m-d',
        'decharged_at' => 'date:Y-m-d',
    ];

    protected $dates = [
    ];

    public static function install(
        Board $board,
        int $member_id,
        string $title,
        DateTimeImmutable $installed_at,
        ?string $photo
    ) : self {
        $legacy_member = \Francken\Association\LegacyMember::find($member_id);

        $member = $board->members()->make([
            'member_id' => $member_id,
            'name' => optional($legacy_member)->full_name ?? '',
            'title' => $title,
            'photo' => $photo,
            'installed_at' => $installed_at,
        ]);
        $member->refreshStatus();

        return $member;
    }

    public function member()
    {
        return $this->belongsTo(LegacyMember::class, 'member_id');
    }

    public function getFullNameAttribute()
    {
        return $this->member->full_name;
    }

    /**
     * We prefer to use this method to update the attributes of a board member
     * so that we can encapsulate changing a member's name based on their profile
     * and we can change the status of a member based on the stall, demissioned
     * and decharged dates
     */
    public function updateBoardMemberAttributes(
        int $member_id,
        string $title,
        DateTimeImmutable $installed_at,
        ?DateTimeImmutable $demissioned_at,
        ?DateTimeImmutable $decharged_at,
        ?string $photo
    ) : void {
        $legacy_member = \Francken\Association\LegacyMember::find($member_id);
        $this->member_id = $member_id;
        $this->name = optional($legacy_member)->full_name ?? '';
        $this->title = $title;
        $this->installed_at = $installed_at;
        $this->demissioned_at = $demissioned_at;
        $this->decharged_at = $decharged_at;
        $this->refreshStatus();

        if ($photo !== null) {
            $this->photo = $photo;
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

        switch ($status) {
            case BoardMemberStatus::CANDIDATE:
                event(new MemberBecameCandidateBoardMember($this->board_id, $this->id));
                break;
            case BoardMemberStatus::BOARD_MEMBER:
                event(new BoardMemberWasInstalled($this->board_id, $this->id));
                break;
            case BoardMemberStatus::DEMISSIONED_BOARD_MEMBER:
                event(new BoardMemberWasDemissioned($this->board_id, $this->id));
                break;
            case BoardMemberStatus::DECHARGED_BOARD_MEMBER:
                event(new BoardMemberWasDischarged($this->board_id, $this->id));
                break;
        }
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
