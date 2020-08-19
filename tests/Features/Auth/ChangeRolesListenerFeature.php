<?php

declare(strict_types=1);

namespace Francken\Features\Auth;

use Francken\Association\Boards\BoardMember;
use Francken\Association\Boards\BoardMemberStatus;
use Francken\Association\Boards\BoardMemberWasDemissioned;
use Francken\Association\Boards\BoardMemberWasDischarged;
use Francken\Association\Boards\BoardMemberWasInstalled;
use Francken\Association\Boards\MemberBecameCandidateBoardMember;
use Francken\Association\Committees\CommitteeMember;
use Francken\Auth\Account;
use Francken\Auth\AccountWasActivated;
use Francken\Auth\ChangeRolesListener;
use Francken\Auth\Role;
use Francken\Features\TestCase;
use UnexpectedValueException;

class ChangeRolesListenerFeature extends TestCase
{
    /** @test */
    public function it_assigns_no_roles_to_a_new_account_from_an_inactive_member() : void
    {
        $account = factory(Account::class)->create();

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(new AccountWasActivated($account));

        $this->assertEmpty($account->roles);
    }

    /** @test */
    public function it_assigns_roles_to_a_new_account_from_a_committee_member() : void
    {
        $account = factory(Account::class)->create();
        $committeeMember = factory(CommitteeMember::class)->create([
            'member_id' => $account->member_id
       ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(new AccountWasActivated($account));

        $this->assertCount(2, $account->roles);
        $this->assertTrue($account->hasRole(Role::fromCommittee($committeeMember->committee)));
        $this->assertTrue($account->hasRole(ChangeRolesListener::ACTIVE_MEMBER_ROLE));
    }

    /** @test */
    public function it_assigns_roles_to_a_new_account_from_a_candidate_board_member() : void
    {
        $account = factory(Account::class)->create();
        factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::CANDIDATE,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(new AccountWasActivated($account));

        $this->assertCount(2, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::CANDIDATE_BOARD_ROLE));
        $this->assertTrue($account->hasRole(ChangeRolesListener::ACTIVE_MEMBER_ROLE));
    }

    /** @test */
    public function it_assigns_roles_to_a_new_account_from_a_board_member() : void
    {
        $account = factory(Account::class)->create();
        factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::BOARD_MEMBER,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(new AccountWasActivated($account));

        $this->assertCount(2, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::BOARD_ROLE));
        $this->assertTrue($account->hasRole(ChangeRolesListener::ACTIVE_MEMBER_ROLE));
    }

    /** @test */
    public function it_assigns_roles_to_a_new_account_from_a_demissioned_board_member() : void
    {
        $account = factory(Account::class)->create();
        factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::DEMISSIONED_BOARD_MEMBER,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(new AccountWasActivated($account));

        $this->assertCount(1, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::DEMISSIONED_BOARD_ROLE));
    }

    /** @test */
    public function it_assigns_roles_to_a_new_account_from_a_decharged_board_member() : void
    {
        $account = factory(Account::class)->create();
        factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::DECHARGED_BOARD_MEMBER,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(new AccountWasActivated($account));

        $this->assertCount(1, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::DECHARGED_BOARD_ROLE));
    }

    /** @test */
    public function it_fails_when_a_board_member_has_an_unknown_status() : void
    {
        $account = factory(Account::class)->create();
        factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => 'unkown_status',
        ]);

        $this->expectException(UnexpectedValueException::class);
        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(new AccountWasActivated($account));
    }

    /** @test */
    public function it_assigns_a_role_to_a_candidate_board_member() : void
    {
        $account = factory(Account::class)->create();
        $boardMember = factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::CANDIDATE,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(
            new MemberBecameCandidateBoardMember($boardMember->board_id, $boardMember->member_id)
        );

        $this->assertCount(2, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::CANDIDATE_BOARD_ROLE));
        $this->assertTrue($account->hasRole(ChangeRolesListener::ACTIVE_MEMBER_ROLE));
    }

    /** @test */
    public function it_assigns_a_role_to_a_installed_board_member() : void
    {
        $account = factory(Account::class)->create();
        $boardMember = factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::BOARD_MEMBER,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(
            new BoardMemberWasInstalled($boardMember->board_id, $boardMember->member_id)
        );

        $this->assertCount(2, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::BOARD_ROLE));
        $this->assertTrue($account->hasRole(ChangeRolesListener::ACTIVE_MEMBER_ROLE));
    }

    /** @test */
    public function it_assigns_a_role_to_a_demissioned_board_member() : void
    {
        $account = factory(Account::class)->create();
        $boardMember = factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::DEMISSIONED_BOARD_MEMBER,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(
            new BoardMemberWasDemissioned($boardMember->board_id, $boardMember->member_id)
        );

        $this->assertCount(1, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::DEMISSIONED_BOARD_ROLE));
    }

    /** @test */
    public function it_assigns_a_role_to_a_decharged_board_member() : void
    {
        $account = factory(Account::class)->create();
        $boardMember = factory(BoardMember::class)->create([
            'member_id' => $account->member_id,
            'board_member_status' => BoardMemberStatus::DECHARGED_BOARD_MEMBER,
        ]);

        $changeRolesListener = new ChangeRolesListener();
        $changeRolesListener->handle(
            new BoardMemberWasDischarged($boardMember->board_id, $boardMember->member_id)
        );

        $this->assertCount(1, $account->roles);
        $this->assertTrue($account->hasRole(ChangeRolesListener::DECHARGED_BOARD_ROLE));
    }
}
