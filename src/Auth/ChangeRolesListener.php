<?php

declare(strict_types=1);

namespace Francken\Auth;

use Francken\Application\Committees\Committee;
use Francken\Application\Committees\CommitteesRepository;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Francken\Association\Boards\BoardMemberWasDemissioned;
use Francken\Association\Boards\BoardMemberWasDischarged;
use Francken\Association\Boards\BoardMemberWasInstalled;
use Francken\Association\Boards\MemberBecameCandidateBoardMember;
use Spatie\Permission\Models\Role;

final class ChangeRolesListener
{
    public const ACTIVE_MEMBER_ROLE = 'Active Member';
    public const BOARD_ROLE = 'Board';
    public const CANDIDATE_BOARD_ROLE = 'Candidate Board';
    public const DEMISSIONED_BOARD_ROLE = 'Demissioned Board';
    public const DECHARGED_BOARD_ROLE = 'Decharged Board';

    /**
     * @var CommitteesRepository
     */
    private $committees;

    public function __construct(CommitteesRepository $committees)
    {
        $this->committees = $committees;
    }

    public function handle($event) : void
    {
        $method = $this->getHandleMethod($event);

        if ( ! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    public function whenAccountWasActivated(
        AccountWasActivated $event
    ) : void {
        \Log::info('Activating an account');
        /** @var Account */
        $account = Account::findOrFail($event->accountId());

        $committees = $this->committees->ofMember($account->member_id);

        foreach ($committees as $committee) {
            $account->assignRole(
                $this->roleForCommittee($committee)
            );
        }

        /** @var \Illuminate\Support\Collection */
        $as_board_members = BoardMember::where('member_id', '=', $account->member_id)->get();
        // Ideally each member should be in only 1 board, and we will assume that
        // this is the case as otherwise wed things will happen where an account
        // can have both an board and an candidate board role
        // If this happens we can simply fix that by manually changing the account's roles
        $as_board_members->each(function (BoardMember $member) use ($account) : void {
            $account->assignRole($this->boardMemberRole($member));
        });

        // Anyone who is in a committee or (will be) a board member is
        // considered an active member
        if (count($committees) > 0 ||
            $account->hasRole(static::BOARD_ROLE) ||
            $account->hasRole(static::CANDIDATE_BOARD_ROLE)
        ) {
            $account->assignRole(static::ACTIVE_MEMBER_ROLE);
        }
    }

    public function whenMemberBecameCandidateBoardMember(
        MemberBecameCandidateBoardMember $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();

        if ($account !== null) {
            $account->assignRole(static::CANDIDATE_BOARD_ROLE);
            $account->assignRole(static::ACTIVE_MEMBER_ROLE);
        }
    }

    public function whenBoardMemberWasInstalled(
        BoardMemberwasInstalled $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();
        if ($account !== null) {
            $account->assignRole(static::BOARD_ROLE);
            $account->removeRole(static::CANDIDATE_BOARD_ROLE);
            $account->assignRole(static::ACTIVE_MEMBER_ROLE);
        }
    }

    public function whenBoardMemberWasDemissioned(
        BoardMemberWasDemissioned $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();

        if ($account !== null) {
            $account->assignRole(static::DEMISSIONED_BOARD_ROLE);
            $account->removeRole(static::BOARD_ROLE);

            // Since this member is no longer in the board nor a member of a committee
            // their active member role will be removed
            $committees = $this->committees->ofMember($account->member_id);
            if (count($committees) === 0) {
                $account->removeRole(static::ACTIVE_MEMBER_ROLE);
            }
        }
    }

    public function whenBoardMemberWasDecharged(
        BoardMemberWasDischarged $event
    ) : void {
        /** @var Account|null */
        $account = Account::ofMember($event->memberId())->first();

        if ($account !== null) {
            $account->assignRole(static::DECHARGED_BOARD_ROLE);
            $account->removeRole(static::DEMISSIONED_BOARD_ROLE);
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
                    throw new \UnexpectedValueException(
                        "Member has an unkown board member status: [{$member->board_member_statusg}]"
                    );
            }
    }

    private function roleForCommittee(Committee $committee)
    {
        return Role::firstOrCreate([
            'name' => $this->committeeRoleName($committee)
        ]);
    }

    private function committeeRoleName(Committee $committee) : string
    {
        return 'Committee ' . $committee->name();
    }

    private function getHandleMethod($event)
    {
        $classParts = explode('\\', get_class($event));

        return 'when' . end($classParts);
    }
}
