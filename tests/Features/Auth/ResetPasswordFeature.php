<?php

declare(strict_types=1);

namespace Francken\Features\Auth;

use Francken\Auth\Account;
use Francken\Auth\Http\Controllers\ResetPasswordController;
use Francken\Features\TestCase;
use Hash;
use Password;

class ResetPasswordFeature extends TestCase
{
    /** @test */
    public function it_allows_an_account_to_login() : void
    {
        $account = factory(Account::class)->create([
            'password' => Hash::make('hoi')
        ]);
        $token = Password::broker()->createToken($account);

        $this
            ->visit(action(
                [ResetPasswordController::class, 'showResetForm'],
                ['token' => $token, ]
            ))
            ->type($account->email, 'email')
            ->type('Horse Battery Staple Correct', 'password')
            ->type('Horse Battery Staple Correct', 'password_confirmation')
            ->press('Reset password')
            ->seeIsAuthenticatedAs($account);

        $account->refresh();

        $this->assertTrue(
            Hash::check('Horse Battery Staple Correct', $account->password)
        );
    }
}
