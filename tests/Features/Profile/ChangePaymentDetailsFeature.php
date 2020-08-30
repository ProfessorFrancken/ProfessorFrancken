<?php

declare(strict_types=1);

namespace Francken\Features\Profile;

use Francken\Association\Members\Events\MemberPaymentDetailsWereChanged;
use Francken\Association\Members\Http\PaymentDetailsController;
use Francken\Association\Members\Http\ProfileController;
use Francken\Auth\Account;
use Francken\Features\TestCase;
use Illuminate\Support\Facades\Event;

class ChangePaymentDetailsFeature extends TestCase
{
    /** @test */
    public function it_allows_changing_a_members_contact_details() : void
    {
        $account = factory(Account::class)->create();

        auth()->login($account);

        Event::fake([
            MemberPaymentDetailsWereChanged::class,
        ]);

        $this->visit(action([ProfileController::class, 'index']))
            ->see('change your password')
            ->visit(action([PaymentDetailsController::class, 'index']))
            ->type('NL91 ABNA 0417 1643 00', 'iban')
            ->check('deduct_additional_costs')
            ->press('Save')
            ->seePageIs(action([ProfileController::class, 'index']));

        $member = $account->member;

        $this->assertEquals('NL91ABNA0417164300', $member->payment_details->iban());
        $this->assertTrue($member->payment_details->deductAdditionalCosts());

        Event::assertDispatched(MemberPaymentDetailsWereChanged::class);
    }
}
