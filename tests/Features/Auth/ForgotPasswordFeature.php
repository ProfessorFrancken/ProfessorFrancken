<?php

declare(strict_types=1);

namespace Francken\Features\Auth;

use Francken\Auth\Account;
use Francken\Auth\Http\Controllers\ForgotPasswordController;
use Francken\Features\TestCase;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordFeature extends TestCase
{
    /** @test */
    public function it_allows_an_account_to_login() : void
    {
        $account = factory(Account::class)->create([
            'password' => Hash::make('hoi')
        ]);

        Notification::fake();

        $this->visit(action([ForgotPasswordController::class, 'showLinkRequestForm']))
            ->type($account->email, 'email')
            ->press('Send password reset link');

        Notification::assertSentTo([$account], ResetPassword::class);
    }
}
