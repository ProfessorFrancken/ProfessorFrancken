<?php

declare(strict_types=1);

namespace Francken\Features\Association\Borrelcie;

use Francken\Association\Borrelcie\Anytimer;
use Francken\Association\Borrelcie\BorrelcieAccount;
use Francken\Association\Borrelcie\Http\AnytimersController;
use Francken\Association\Borrelcie\Http\BorrelcieAccountActivationController;
use Francken\Association\Borrelcie\Http\BorrelcieController;
use Francken\Auth\Account;
use Francken\Features\TestCase;

class BorrelcieFeature extends TestCase
{
    /** @test */
    public function it_allows_a_member_to_activate_their_borrelcie_account() : void
    {
        $account = factory(Account::class)->create();
        $this
            ->actingAs($account)
            ->visit(action([BorrelcieController::class, 'index']))
            ->followRedirects()
            ->seePageIs(action([BorrelcieAccountActivationController::class, 'index']))
            ->press('Activate your account')
            ->seePageIs(action([BorrelcieController::class, 'index']));
    }

    /** @test */
    public function it_shows_a_members_anytimers() : void
    {
        $account = factory(Account::class)->create();
        $borrelcieAccount = factory(BorrelcieAccount::class)->create([
            'member_id' => $account->member_id
        ]);

        $givenAnytimer = factory(Anytimer::class)->state('given')->create([
            'drinker_id' => $borrelcieAccount->id,
            'accepted' => true,
        ]);
        $claimedAnytimer = factory(Anytimer::class)->state('claimed')->create([
            'owner_id' => $borrelcieAccount->id,
            'accepted' => true,
        ]);

        // Add two pending anytimers
        factory(Anytimer::class)->state('claimed')->create([
            'owner_id' => $borrelcieAccount->id,
            'accepted' => false,
            'amount' => 1,
        ]);
        factory(Anytimer::class)->state('used')->create([
            'owner_id' => $borrelcieAccount->id,
            'accepted' => false,
            'amount' => -2,
        ]);

        $this
            ->actingAs($account)
            ->visit(action([AnytimersController::class, 'index']))
            ->see($givenAnytimer->owner->fullname)
            ->see($claimedAnytimer->drinker->fullname)
            ->see("Claimed 1 anytimer from")
            ->see("Used 2 anytimers on");
    }

    /** @test */
    public function it_allows_a_member_to_accept_a_claimed_anytimer() : void
    {
        $account = factory(Account::class)->create();
        $borrelcieAccount = factory(BorrelcieAccount::class)->create([
            'member_id' => $account->member_id
        ]);

        $givenAnytimer = factory(Anytimer::class)->state('claimed')->create([
            'drinker_id' => $borrelcieAccount->id,
            'accepted' => false,
        ]);

        $this
            ->actingAs($account)
            ->visit(action([AnytimersController::class, 'index']))
            ->see($givenAnytimer->owner->fullname)
            ->see('Accept')
            ->press('Accept');

        $givenAnytimer->refresh();
        $this->assertTrue($givenAnytimer->accepted);
    }

    /** @test */
    public function it_allows_a_member_to_accept_a_given_anytimer() : void
    {
        $account = factory(Account::class)->create();
        $borrelcieAccount = factory(BorrelcieAccount::class)->create([
            'member_id' => $account->member_id
        ]);

        $givenAnytimer = factory(Anytimer::class)->state('given')->create([
            'owner_id' => $borrelcieAccount->id,
            'accepted' => false,
        ]);

        $this
            ->actingAs($account)
            ->visit(action([AnytimersController::class, 'index']))
            ->see($givenAnytimer->owner->fullname)
            ->see('Accept')
            ->press('Accept');

        $givenAnytimer->refresh();
        $this->assertTrue($givenAnytimer->accepted);
    }

    /** @test */
    public function it_allows_a_member_to_accept_a_drank_anytimer() : void
    {
        $account = factory(Account::class)->create();
        $borrelcieAccount = factory(BorrelcieAccount::class)->create([
            'member_id' => $account->member_id
        ]);

        $givenAnytimer = factory(Anytimer::class)->state('drank')->create([
            'owner_id' => $borrelcieAccount->id,
            'accepted' => false,
        ]);

        $this
            ->actingAs($account)
            ->visit(action([AnytimersController::class, 'index']))
            ->see($givenAnytimer->owner->fullname)
            ->see('Accept')
            ->press('Accept');

        $givenAnytimer->refresh();
        $this->assertTrue($givenAnytimer->accepted);
    }

    /** @test */
    public function it_allows_a_member_to_accept_a_used_anytimer() : void
    {
        $account = factory(Account::class)->create();
        $borrelcieAccount = factory(BorrelcieAccount::class)->create([
            'member_id' => $account->member_id
        ]);

        $givenAnytimer = factory(Anytimer::class)->state('used')->create([
            'drinker_id' => $borrelcieAccount->id,
            'accepted' => false,
        ]);

        $this
            ->actingAs($account)
            ->visit(action([AnytimersController::class, 'index']))
            ->see($givenAnytimer->owner->fullname)
            ->see('Accept')
            ->press('Accept');

        $givenAnytimer->refresh();
        $this->assertTrue($givenAnytimer->accepted);
    }

    /** @test */
    public function it_allows_a_member_to_reject_a_used_anytimer() : void
    {
        $account = factory(Account::class)->create();
        $borrelcieAccount = factory(BorrelcieAccount::class)->create([
            'member_id' => $account->member_id
        ]);

        $givenAnytimer = factory(Anytimer::class)->state('used')->create([
            'drinker_id' => $borrelcieAccount->id,
            'accepted' => false,
        ]);

        $this
            ->actingAs($account)
            ->visit(action([AnytimersController::class, 'index']))
            ->see($givenAnytimer->owner->fullname)
            ->see('Reject')
            ->press('Reject');

        $givenAnytimer->refresh();
        $this->assertNotNull($givenAnytimer->deleted_at);
    }

    /** @test */
    public function it_allows_a_member_to_claim_an_anytimer() : void
    {
        $account = factory(Account::class)->create();
        $borrelcieAccount = factory(BorrelcieAccount::class)->create([
            'member_id' => $account->member_id
        ]);

        $otherAccount = factory(BorrelcieAccount::class)->create();

        $this
            ->actingAs($account)
            ->post(action([AnytimersController::class, 'store']), [
                'drinker_id' => $otherAccount->id,
                'owner_id' => $borrelcieAccount->id,
                'amount' => 1,
                'reason' => null,
                'context' => 'claimed'
            ])
            ->followRedirects()
            ->seePageIs(action([AnytimersController::class, 'index']))
            ->see($otherAccount->member->fullname);
    }
}
