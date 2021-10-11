<?php

declare(strict_types=1);

namespace Francken\Features\Profile;

use DateTimeImmutable;
use Francken\Association\Members\Http\FranckenVrijSubscriptionController;
use Francken\Auth\Account;
use Francken\Features\TestCase;

class ChangeFranckenVrijSubscriptionFeature extends TestCase
{
    /** @test */
    public function it_allows_changing_a_members_subscription_expiration_date() : void
    {
        $account = factory(Account::class)->create();

        auth()->login($account);

        $date = $this->getNextFirstOfSeptember();
        $year = $date->format('Y');

        $this->visit(action([FranckenVrijSubscriptionController::class, 'index']))
            ->select("September {$year}", 'subsription_ends_at')
            ->check('send_expiration_notification')
            ->press('Subscribe')
            ->seePageIs(action([FranckenVrijSubscriptionController::class, 'index']));

        $member = $account->member;
        $this->assertTrue($member->receive_francken_vrij);
        $this->assertEquals($member->franckenVrijSubscription->subscription_ends_at->format("Y"), $year);
        $this->assertTrue($member->franckenVrijSubscription->send_expiration_notification);

        $this->select("CANCEL", 'subsription_ends_at')
            ->uncheck('send_expiration_notification')
            ->press('Update subscription');

        $this->assertNull($member->franckenVrijSubscription->subscription_ends_at);
        $this->assertFalse($member->franckenVrijSubscription->send_expiration_notification);
        $this->assertFalse($member->franckenVrijSubscription->send_expiration_notification);
    }

    private function getNextFirstOfSeptember() : DateTimeImmutable
    {
        $now = new DateTimeImmutable();
        $septemberThisYear = new DateTimeImmutable('September');

        if ($now >= $septemberThisYear) {
            return $septemberThisYear->modify('+1 year');
        }

        return $septemberThisYear;
    }
}
