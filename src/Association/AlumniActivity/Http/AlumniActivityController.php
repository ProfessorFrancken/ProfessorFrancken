<?php

declare(strict_types=1);

namespace Francken\Association\AlumniActivity\Http;

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
}
