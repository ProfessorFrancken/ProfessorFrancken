<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Francken\Association\Members\Http\Requests\PaymentDetailsRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PaymentDetailsController
{
    public function index(Request $request) : View
    {
        $member = $request->user()->member;

        return view('profile.payment-details.index')
            ->with([
                'member' => $member,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                    ['url' => action([self::class, 'index']), 'text' => 'Payment details'],
                ]
            ]);
    }

    public function update(PaymentDetailsRequest $request) : RedirectResponse
    {
        $member = $request->user()->member;
        $member->changePaymentDetails($request->paymentDetails());

        return redirect()->action([ProfileController::class, 'index']);
    }
}
