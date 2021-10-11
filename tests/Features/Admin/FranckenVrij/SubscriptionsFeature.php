<?php

declare(strict_types=1);

namespace Francken\Features\Admin\FranckenVrij;

use DateTimeImmutable;
use Francken\Association\FranckenVrij\Exports\SubscriptionsExport;
use Francken\Association\FranckenVrij\Http\AdminSubscriptionsController;
use Francken\Association\FranckenVrij\Http\AdminSubscriptionsExportController;
use Francken\Association\FranckenVrij\Subscription;
use Francken\Association\LegacyMember;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionsFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_shows_members_with_a_francken_vrij_subscription() : void
    {
        $today = new DateTimeImmutable();
        $nextYear = $today->modify('+1 year');
        $previousYear = $today->modify('-1 year');

        /** @var Collection $subscriptions */
        $subscriptions = factory(Subscription::class, 20)->create();
        $activeSubscriptions = $subscriptions->filter(fn (Subscription $subscription) => $subscription->isActiveAt($today));
        $expiredSubscriptions = $subscriptions->reject(fn (Subscription $subscription) => $subscription->subscription_ends_at === null)
                                              ->reject(fn (Subscription $subscription) => $subscription->isActiveAt($today));
        $cancelledSubscriptions = $subscriptions->filter(fn (Subscription $subscription) => $subscription->subscription_ends_at === null);

        $recentlyExpiredSubscriptions = $subscriptions->filter(
            fn (Subscription $subscription) => $subscription->isActiveAt($previousYear) && ! $subscription->isActiveAt($today)
        );
        $soonToBeExpiredSubscriptions = $subscriptions->filter(
            fn (Subscription $subscription) => $subscription->isActiveAt($today) && ! $subscription->isActiveAt($nextYear)
        );


        $this->visit(action([AdminSubscriptionsController::class, 'index']));
        $this->seeElementCount('.subscription', $activeSubscriptions->count());

        $this->visit(action([AdminSubscriptionsController::class, 'index'], ['select' => 'recently-expired-subscription']));
        $this->seeElementCount('.subscription', $recentlyExpiredSubscriptions->count());

        $this->visit(action([AdminSubscriptionsController::class, 'index'], ['select' => 'expired-subscription']));
        $this->seeElementCount('.subscription', $expiredSubscriptions->count());

        $this->visit(action([AdminSubscriptionsController::class, 'index'], ['select' => 'soon-to-be-expired']));
        $this->seeElementCount('.subscription', $soonToBeExpiredSubscriptions->count());

        $this->visit(action([AdminSubscriptionsController::class, 'index'], ['select' => 'cancelled']));
        $this->seeElementCount('.subscription', $cancelledSubscriptions->count());
    }

    /** @test */
    public function it_allows_a_board_member_to_export_subscription_addresses() : void
    {
        Excel::fake();

        $today = new DateTimeImmutable();
        $subscriptions = factory(Subscription::class, 10)->create();
        $expectedSubscriptions = $subscriptions->filter(fn (Subscription $subscription) => $subscription->isActiveAt($today));

        $this->get(action([AdminSubscriptionsExportController::class, 'index']));

        Excel::assertDownloaded(sprintf("francken-vrij-subscriptions-%s.xlsx", $today->format('Y-m-d')), function (SubscriptionsExport $export) use ($expectedSubscriptions) : bool {
            ["subscriptions" => $subscriptions] = $export->view()->getData();
            $this->assertCount($expectedSubscriptions->count(), $subscriptions);
            return true;
        });
    }


    /** @test */
    public function it_allows_a_board_member_to_update_ones_subscription() : void
    {
        $subscription = factory(Subscription::class)->create();

        $date = $this->getNextFirstOfSeptember();
        $year = $date->format('Y');

        $this->visit(action([AdminSubscriptionsController::class, 'edit'], ['subscription' => $subscription]))
            ->select("September {$year}", 'subsription_ends_at')
            ->check('send_expiration_notification')
            ->press('Save');

        $subscription->refresh();
        $member = $subscription->member;
        $this->assertTrue($member->receive_francken_vrij);
        $this->assertEquals($subscription->subscription_ends_at->format("Y"), $year);
        $this->assertTrue($subscription->send_expiration_notification);

        $this->visit(action([AdminSubscriptionsController::class, 'edit'], ['subscription' => $subscription]));
        $this->select("CANCEL", 'subsription_ends_at')
            ->uncheck('send_expiration_notification')
            ->press('Save');

        $subscription->refresh();
        $member = $subscription->member;
        $this->assertNull($subscription->subscription_ends_at);
        $this->assertFalse($subscription->send_expiration_notification);
        $this->assertFalse($member->receive_francken_vrij);
    }

    /** @test */
    public function it_allows_a_board_member_to_create_a_subscription() : void
    {
        $member = factory(LegacyMember::class)->create(['is_lid' => true]);

        $date = $this->getNextFirstOfSeptember();
        $year = $date->format('Y');

        $this->visit(action([AdminSubscriptionsController::class, 'create']))
            ->type($member->id, 'member_id')
            ->select("September {$year}", 'subsription_ends_at')
            ->check('send_expiration_notification')
            ->press('Save');

        $member->refresh();
        $subscription = $member->franckenVrijSubscription;
        $this->assertTrue($member->receive_francken_vrij);
        $this->assertEquals($subscription->subscription_ends_at->format("Y"), $year);
        $this->assertTrue($subscription->send_expiration_notification);
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
