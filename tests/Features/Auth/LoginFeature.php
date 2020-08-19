<?php

declare(strict_types=1);

namespace Francken\Features\Auth;

use Auth;
use Francken\Association\Members\Http\ProfileController;
use Francken\Auth\Account;
use Francken\Auth\Http\Controllers\LoginController;
use Francken\Features\TestCase;
use Hash;

class LoginFeature extends TestCase
{
    /** @test */
    public function it_allows_an_account_to_login() : void
    {
        $account = factory(Account::class)->create([
            'password' => Hash::make('hoi')
        ]);

        $this->visit(action([LoginController::class, 'showLoginForm']))
            ->type($account->email, 'email')
            ->type('hoi', 'password')
            ->press('Login')
            ->seeIsAuthenticatedAs($account)
            ->seePageIs(action([ProfileController::class, 'index']));
    }

    /** @test */
    public function it_allows_an_account_to_logout() : void
    {
        $account = factory(Account::class)->create([
            'password' => Hash::make('hoi')
        ]);
        Auth::loginUsingId($account->id);

        $this->visit(action([LoginController::class, 'logout']))
             ->dontSeeIsAuthenticated();
    }
}
