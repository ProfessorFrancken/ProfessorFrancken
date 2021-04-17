<?php

declare(strict_types=1);

namespace Francken\Association\FranckenVrij\Http;

use DateTimeImmutable;
use Francken\Association\FranckenVrij\Http\Requests\AdminSearchSubscriptionsRequest;
use Francken\Association\FranckenVrij\Subscription;
use Francken\Association\LegacyMember;
use Francken\Shared\Clock\Clock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Webmozart\Assert\Assert;

final class AdminSubscriptionsController
{
    /**
     * @var int
     */
    private const SUBSCRIPTIONS_PER_PAGE = 50;

    public function index(AdminSearchSubscriptionsRequest $request, Clock $clock) : View
    {
        $now = $clock->now();

        $subscriptions = Subscription::query()
            // ->search($request)
            ->when(
                $request->selected('active-subscription'),
                fn (Builder $query) : Builder => $query->withActiveSubscription($now)
            )
            ->when(
                $request->selected('recently-expired-subscription'),
                fn (Builder $query) : Builder => $query->withRecentlyExpiredSubscription($now)
            )
            ->when(
                $request->selected('expired-subscription'),
                fn (Builder $query) : Builder => $query->withExpiredSubscription($now)
            )
            ->when(
                $request->selected('soon-to-be-expired'),
                fn (Builder $query) : Builder => $query->withSoonToBeExpried($now)
            )
            ->when(
                $request->selected('cancelled'),
                fn (Builder $query) : Builder => $query->cancelled()
            )
            ->with(['member'])
            ->orderBy('updated_at', 'desc')
            ->paginate(self::SUBSCRIPTIONS_PER_PAGE)
            ->appends($request->except('page'));

        return view('admin.francken-vrij.subscriptions.index')
            ->with([
                'request' => $request,
                'subscriptions' => $subscriptions,

                'all_subscriptions' => Subscription::query()->count(),
                'active_subscriptions' =>  Subscription::query()->withActiveSubscription($now)->count(),
                'recently_expired_subscriptions' =>  Subscription::query()->withRecentlyExpiredSubscription($now)->count(),
                'expired_subscriptions' =>  Subscription::query()->withExpiredSubscription($now)->count(),
                'soon_to_be_expired_subscriptions' =>  Subscription::query()->withSoonToBeExpried($now)->count(),
                'cancelled_subscriptions' =>  Subscription::query()->cancelled()->count(),

                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([AdminFranckenVrijController::class, 'index']), 'text' => 'Francken Vrij'],
                    ['url' => action([self::class, 'index']), 'text' => 'Subscriptions'],
                ]
            ]);
    }

    public function create(Request $request, Clock $clock) : View
    {
        $member = $request->input('member_id')
                ? LegacyMember::findOrFail($request->input('member_id'))
                : null;

        $subscription = new Subscription();

        $extensionOptions = array_merge(
                ['CANCEL' => 'Cancel subscription'],
                $this->subscriptionOptions($clock)
            );

        $subscriptionEndsAt = $subscription->subscription_ends_at === null
                            ? 'CANCEL'
                            : 'September ' . $subscription->subscription_ends_at->format('Y');

        return view('admin.francken-vrij.subscriptions.create')
            ->with([
                'subscription' => $subscription,
                'subscriptionEndsAt' => $subscriptionEndsAt,
                'member' => optional($member),
                'extensionOptions' => $extensionOptions,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([AdminFranckenVrijController::class, 'index']), 'text' => 'Francken Vrij'],
                    ['url' => action([self::class, 'index']), 'text' => 'Subscriptions'],
                    ['url' => action([self::class, 'create']), 'text' => 'Create'],
                ]
            ]);
    }

    public function store(Request $request, Clock $clock) : RedirectResponse
    {
        $member = LegacyMember::whereDoesntHave('franckenVrijSubscription')
                ->where('id', $request->input('member_id'))
                ->firstOrFail();

        $subscription = $member->franckenVrijSubscription;

        Assert::isInstanceOf($subscription, Subscription::class);

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

        return redirect()->action([self::class, 'edit'], ['subscription' => $subscription]);
    }

    public function edit(Subscription $subscription, Clock $clock) : View
    {
        Assert::notNull($subscription->member);

        $extensionOptions = array_merge(
                ['CANCEL' => 'Cancel subscription'],
                $this->subscriptionOptions($clock)
            );

        $subscriptionEndsAt = $subscription->subscription_ends_at === null
                            ? 'CANCEL'
                            : 'September ' . $subscription->subscription_ends_at->format('Y');

        return view('admin.francken-vrij.subscriptions.edit')
            ->with([
                'subscription' => $subscription,
                'subscriptionEndsAt' => $subscriptionEndsAt,
                'member' => $subscription->member,
                'extensionOptions' => $extensionOptions,
                'breadcrumbs' => [
                    ['url' => '/association', 'text' => 'Association'],
                    ['url' => action([AdminFranckenVrijController::class, 'index']), 'text' => 'Francken Vrij'],
                    ['url' => action([self::class, 'index']), 'text' => 'Subscriptions'],
                    ['url' => action([self::class, 'edit'], ['subscription' => $subscription]), 'text' => $subscription->member->fullname],
                ]
            ]);
    }

    public function update(Request $request, Subscription $subscription, Clock $clock) : RedirectResponse
    {
        Assert::notNull($subscription->member);

        $member = $subscription->member;

        if ($request->input('subsription_ends_at') === 'CANCEL') {
            $subscription->subscription_ends_at = null;
            $member->mailinglist_franckenvrij = false;
            $member->save();
        } else {
            $date = new \DateTimeImmutable($request->input('subsription_ends_at'));
            $subscription->subscription_ends_at = $date;
            $member->mailinglist_franckenvrij = $subscription->subscription_ends_at > $clock->now();
            $member->save();
        }
        $subscription->send_expiration_notification = (bool)$request->input('send_expiration_notification', false);
        $subscription->save();

        return redirect()->action([self::class, 'edit'], ['subscription' => $subscription]);
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
