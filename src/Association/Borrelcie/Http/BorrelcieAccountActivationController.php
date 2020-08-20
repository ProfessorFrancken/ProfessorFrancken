<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie\Http;

use Francken\Association\Borrelcie\BorrelcieAccount;
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
                ]
            ]);
    }

    public function store(Request $request) : RedirectResponse
    {
        $account = BorrelcieAccount::create(['member_id' => $request->user()->member_id]);

        return redirect()->action([BorrelcieController::class, 'index']);
    }
}
