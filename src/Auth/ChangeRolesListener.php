<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Francken\Association\Boards\BoardMemberWasDemissioned;
use Francken\Association\Boards\BoardMemberWasDischarged;
use Francken\Association\Boards\BoardMemberWasInstalled;
use Francken\Association\Boards\MemberBecameCandidateBoardMember;
use Francken\Association\Committees\Committee;
use Francken\Shared\EventHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Log;
use UnexpectedValueException;

final class ChangeRolesListener extends EventHandler
{
    /**
     * @var string
     */
    public const ACTIVE_MEMBER_ROLE = 'Active Member';

    /**
     * @var string
     */
    public const BOARD_ROLE = 'Board';

    /**
     * @var string
     */
    public const CANDIDATE_BOARD_ROLE = 'Candidate Board';

    /**
     * @var string
     */
    public const DEMISSIONED_BOARD_ROLE = 'Demissioned Board';

    /**
     * @var string
     */
    public const DECHARGED_BOARD_ROLE = 'Decharged Board';

    public function whenAccountWasActivated(
        AccountWasActivated $event
    ) : void {
        Log::info('Activating an account');
        /** @var Account */
        $account = Account::findOrFail($event->accountId());

        $this->assignRolesForActiveCommittees($account);

        /** @var Collection */
        $asBoardMembers = BoardMember::where(
            'member_id',
            '=',
            (int)$account->member_id
        )->get();

        // Ideally each member should be in only 1 board, and we will assume that
        // this is the case as otherwise wed things will happen where an account
        // can have both an board and an candidate board role
        // If this happens we can simply fix that by manually changing the account's roles
        $asBoardMembers->each(function (BoardMember $member) use ($account) : void {
            $account->assignRole($this->role($this->boardMemberRole($member)));
        });


        // Anyone who is in a committee or (will be) a board member is
        // considered an active member
        if (
            $account->hasRole(static::BOARD_ROLE) ||
            $account->hasRole(static::CANDIDATE_BOARD_ROLE)
        ) {
            $account->assignRole($this->role(static::ACTIVE_MEMBER_ROLE));
        }
    }

    public function whenMemberBecameCandidateBoardMember(
        MemberBecameCandidateBoardMember $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();

        if ($account !== null) {
            $account->assignRole($this->role(static::CANDIDATE_BOARD_ROLE));
            $account->assignRole($this->role(static::ACTIVE_MEMBER_ROLE));
        }
    }

    public function whenBoardMemberWasInstalled(
        BoardMemberWasInstalled $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();
        if ($account !== null) {
            $account->assignRole($this->role(static::BOARD_ROLE));
            $account->removeRole($this->role(static::CANDIDATE_BOARD_ROLE));
            $account->assignRole($this->role(static::ACTIVE_MEMBER_ROLE));
        }
    }

    public function whenBoardMemberWasDemissioned(
        BoardMemberWasDemissioned $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();

        if ($account !== null) {
            $account->assignRole($this->role(static::DEMISSIONED_BOARD_ROLE));
            $account->removeRole($this->role(static::BOARD_ROLE));

            // Since this member is no longer in the board nor a member of a committee
            // their active member role will be removed
            $committees = $this->activeCommitteesOfMember($account);
            if ($committees->isEmpty()) {
                $account->removeRole($this->role(static::ACTIVE_MEMBER_ROLE));
            }
        }
    }

    public function whenBoardMemberWasDischarged(
        BoardMemberWasDischarged $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();

        if ($account !== null) {
            $account->assignRole($this->role(static::DECHARGED_BOARD_ROLE));
            $account->removeRole($this->role(static::DEMISSIONED_BOARD_ROLE));
        }
    }

    private function boardMemberRole(BoardMember $member) : string
    {
        switch ($member->board_member_status) {
            case BoardMemberStatus::CANDIDATE: return static::CANDIDATE_BOARD_ROLE;
            case BoardMemberStatus::BOARD_MEMBER: return static::BOARD_ROLE;
            case BoardMemberStatus::DEMISSIONED_BOARD_MEMBER: return static::DEMISSIONED_BOARD_ROLE;
            case BoardMemberStatus::DECHARGED_BOARD_MEMBER: return static::DECHARGED_BOARD_ROLE;
            default:
                throw new UnexpectedValueException(
                    "Member has an unkown board member status: [{$member->board_member_status}]"
                );
        }
    }

    private function assignRolesForActiveCommittees(Account $account) : void
    {
        $committees = $this->activeCommitteesOfMember($account);

        foreach ($committees as $committee) {
            $account->assignRole(
                $this->roleForCommittee($committee)
            );
        }

        if ($committees->isNotEmpty()) {
            $account->assignRole($this->role(static::ACTIVE_MEMBER_ROLE));
        }
    }

    private function activeCommitteesOfMember(Account $account) : Collection
    {
        $board = Board::orderBy('installed_at', 'desc')->first();

        if ($board === null) {
            return collect();
        }

        $committees = $board->committees()
            ->whereHas('members', fn (Builder $query) : Builder => $query->where('member_id', $account->member_id))
            ->get();

        return collect($committees);
    }

    private function roleForCommittee(Committee $committee) : Role
    {
        return $this->role($this->committeeRoleName($committee));
    }

    private function role(string $name) : Role
    {
        /** @var Role */
        return Role::firstOrCreate(['name' => $name]);
    }

    private function committeeRoleName(Committee $committee) : string
    {
        return 'Committee ' . $committee->name;
    }
}
