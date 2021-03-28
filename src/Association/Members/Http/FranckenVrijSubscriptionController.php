<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use DateTimeImmutable;
use Francken\Shared\Clock\Clock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class FranckenVrijSubscriptionController
{
    public function index(Request $request, Clock $clock) : View
    {
        $member = $request->user()->member;

        $subscription = $member->franckenVrijSubscription;

        $extensionOptions = ($subscription->isActiveAt($clock->now()))
            ? array_merge(
                ['CANCEL' => 'Cancel subscription'],
                $this->subscriptionOptions($clock)
            )
            : $this->subscriptionOptions($clock);

        return view('profile.francken-vrij-subscription.index')
            ->with([
                'member' => $member,
                'subscription' => $subscription,
                'extensionOptions' => $extensionOptions,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                    ['url' => action([self::class, 'index']), 'text' => 'Francken Vrij subscription'],
                ]
            ]);
    }

    public function update(Request $request, Clock $clock) : RedirectResponse
    {
        $member = $request->user()->member;
        $subscription = $member->franckenVrijSubscription;

        if ($request->input('subsription_ends_at') === 'CANCEL') {
            $subscription->subscription_ends_at = null;
            $member->mailinglist_franckenvrij = false;
        } else {
            $date = new \DateTimeImmutable($request->input('subsription_ends_at'));
            $subscription->subscription_ends_at = $date;
            $member->mailinglist_franckenvrij = $subscription->subscription_ends_at > $clock->now();
        }
        $subscription->send_expiration_notification = (bool)$request->input('send_expiration_notification', false);


        $subscription->save();
        $member->setConnection('francken-legacy');
        $member->save();

        return redirect()->action([self::class, 'index']);
    }

    private function subscriptionOptions(Clock $clock) : array
    {
        $today = $clock->now();
        $september = $today->modify('first day of september');

        $options = collect(range(0, 6))
            ->map(fn (int $idx) => $september->modify("+${idx} Year"))
            ->filter(fn (DateTimeImmutable $date) => $date > $today)
            ->take(5);


        return $options->mapWithKeys(
            function (DateTimeImmutable $date) use ($today) : array {
                $years = $date->diff($today)->y;

                $key = (string)$date->format("F Y");
                if ($years === 0) {
                    return [$key => $date->format("F Y")];
                }

                if ($years === 1) {
                    return [$key => sprintf("%s (1 year)", $date->format("F Y"))];
                }

                return [
                    $key => sprintf("%s (%d years)", $date->format("F Y"), $years)
                ];
            }
        )->toArray();
    }
}
