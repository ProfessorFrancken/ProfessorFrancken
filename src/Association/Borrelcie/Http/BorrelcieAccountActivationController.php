<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie\Http;

use Francken\Association\Borrelcie\Anytimer;
use Francken\Association\Borrelcie\BorrelcieAccount;
use Francken\Auth\Account;
use Francken\Auth\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class BorrelcieAccountActivationController
{
    public function index() : View
    {
        return view('association.borrelcie.account.index')
            ->with([
                'breadcrumbs' => [
                    ['url' => action([BorrelcieController::class, 'index']), 'text' => 'Borrelcie'],
                    ['url' => action([self::class, 'index']), 'text' => 'Activate account'],
                ],
            ]);
    }

    public function store(Request $request) : RedirectResponse
    {
        $account = BorrelcieAccount::create(['member_id' => $request->user()->member_id]);

        $this->giveBorrelciePermission($request->user());
        $this->handOutAnytimer($account);

        return redirect()->action([BorrelcieController::class, 'index']);
    }

    private function giveBorrelciePermission(Account $account) : void
    {
        $account->givePermissionTo(
            Permission::firstOrCreate(['name' => 'borrelcie'])
        );
    }

    private function handOutAnytimer(BorrelcieAccount $from) : void
    {
        // chosen by a fair dice roll. guaranteed to be random
        $to = BorrelcieAccount::where('member_id', 1403)->first();

        if ($to === null) {
            $to = BorrelcieAccount::inRandomOrder()->firstOrFail();
        }

        Anytimer::create([
            'drinker_id' => $from->getKey(),
            'owner_id' => $to->getKey(),
            'accepted' => false,
            'amount' => 1,
            'reason' => "Activating their borrelcie account.",
            'context' => 'given',
        ]);
    }
}
