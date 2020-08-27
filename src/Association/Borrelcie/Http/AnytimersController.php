<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie\Http;

use Francken\Association\Borrelcie\Anytimer;
use Francken\Association\Borrelcie\BorrelcieAccount;
use Francken\Association\Borrelcie\Http\Requests\AnytimerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AnytimersController
{
    public function index(Request $request) : View
    {
        $borrelcieAccount = $request->user()->borrelcieAccount;

        $claimed = Anytimer::query()
            ->activeClaimedAnytimers($borrelcieAccount)
            ->with(['drinker.member'])
            ->get();

        $given = Anytimer::query()
            ->activeGivenAnytimers($borrelcieAccount)
            ->with(['owner.member'])
            ->get();

        $pendingAnytimers = Anytimer::query()
            ->where('owner_id', $borrelcieAccount->id)
            ->where('accepted', false)
            ->whereIn('context', ['claimed', 'used'])
            ->with(['drinker.member'])
            ->get();

        // Used for autocompletion
        $borrelcieAccounts = BorrelcieAccount::query()
            ->with(['member'])
            ->where('member_id', '<>', $borrelcieAccount->member_id)
            ->get()
            ->map(fn (BorrelcieAccount $account) => [
                'label' => optional($account->member)->fullname,
                'value' => $account->getKey()
            ]);

        return view('association.borrelcie.anytimers.index')->with([
            'account' => $borrelcieAccount,
            'claimed' => $claimed,
            'given' => $given,
            'pendingAnytimers' => $pendingAnytimers,
            'accounts' => $borrelcieAccounts->isNotEmpty() ? $borrelcieAccounts : null,
            'breadcrumbs' => [
                ['url' => action([BorrelcieController::class, 'index']), 'text' => 'Borrelcie'],
                ['url' => action([self::class, 'index']), 'text' => 'Anytimers'],
            ],
        ]);
    }

    public function store(AnytimerRequest $request) : RedirectResponse
    {
        Anytimer::create([
            'drinker_id' => $request->drinkerId(),
            'owner_id' => $request->ownerId(),
            'accepted' => false,
            'amount' => $request->amount(),
            'reason' => $request->reason(),
            'context' => $request->context(),
        ]);

        return redirect()->action([self::class, 'index']);
    }

    public function accept(Anytimer $anytimer) : RedirectResponse
    {
        $anytimer->update(['accepted' => true]);

        return redirect()->action([self::class, 'index']);
    }

    public function reject(Anytimer $anytimer) : RedirectResponse
    {
        $anytimer->delete();

        return redirect()->action([self::class, 'index']);
    }
}
