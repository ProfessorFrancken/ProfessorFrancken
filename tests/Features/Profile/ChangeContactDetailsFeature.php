<?php

declare(strict_types=1);

namespace Francken\Features\Profile;

use Francken\Association\Members\Address;
use Francken\Association\Members\Events\MemberAddressWasChanged;
use Francken\Association\Members\Events\MemberEmailWasChanged;
use Francken\Association\Members\Events\MemberPhoneNumberWasChanged;
use Francken\Association\Members\Http\ContactDetailsController;
use Francken\Association\Members\Http\ProfileController;
use Francken\Auth\Account;
use Francken\Features\TestCase;
use Illuminate\Support\Facades\Event;

class ChangeContactDetailsFeature extends TestCase
{
    /** @test */
    public function it_allows_changing_a_members_contact_details() : void
    {
        $account = factory(Account::class)->create();

        auth()->login($account);

        Event::fake([
            MemberEmailWasChanged::class,
            MemberAddressWasChanged::class,
            MemberPhoneNumberWasChanged::class,
        ]);

        $this->visit(action([ProfileController::class, 'index']))
            ->see('change your password')
            ->visit(action([ContactDetailsController::class, 'index']))
            ->type('markredeman@gmail.com', 'email')
            ->check('newsletter')
            ->type('Nijenborgh 4', 'address')
            ->type('Groningen', 'city')
            ->type('9747AG', 'postal_code')
            ->type('Netherlands', 'country')
            ->type('+1-202-555-0178', 'phone_number')
            ->press('Save')
            ->seePageIs(action([ProfileController::class, 'index']));

        $member = $account->member;

        $this->assertEquals('markredeman@gmail.com', $member->email->toString());
        $this->assertTrue($member->receive_newsletter);
        $this->assertEquals(
            new Address(
                'Groningen',
                '9747AG',
                'Nijenborgh 4',
                'Netherlands'
            ),
            $member->address
        );
        $this->assertEquals('+1-202-555-0178', $member->phone_number);

        Event::assertDispatched(MemberEmailWasChanged::class);
        Event::assertDispatched(MemberAddressWasChanged::class);
        Event::assertDispatched(MemberPhoneNumberWasChanged::class);
    }
}
