<?php

declare(strict_types=1);

namespace Francken\Shared\ViewComponents;

use Francken\Association\Borrelcie\Anytimer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class BorrelcieNotificationsComponent extends Component
{
    public Collection $notifications;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->notifications = collect();

        if ($request->user() === null) {
            return;
        }

        $account = $request->user()->borrelcieAccount;

        if ($account === null) {
            return;
        }

        $this->notifications = Anytimer::query()
            ->where('accepted', false)
            ->where(function (Builder $query) use ($account) : void {
                $query->where(fn ($q) => $q->where('context', 'given')->where('owner_id', $account->id))
                    ->orWhere(fn ($q) => $q->where('context', 'claimed')->where('drinker_id', $account->id))
                    ->orWhere(fn ($q) => $q->where('context', 'used')->where('drinker_id', $account->id))
                    ->orWhere(fn ($q) => $q->where('context', 'drank')->where('owner_id', $account->id));
            })
            ->with(['owner.member', 'drinker.member'])
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('association.borrelcie.notifications');
    }
}
