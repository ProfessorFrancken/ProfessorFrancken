<?php

declare(strict_types=1);

namespace Francken\Features\Profile;

use Francken\Association\Members\Http\PasswordController;
use Francken\Association\Members\Http\ProfileController;
use Francken\Auth\Account;
use Francken\Features\TestCase;
use Illuminate\Contracts\Hashing\Hasher;

class ChangePasswordFeature extends TestCase
{
    /** @test */
    public function it_allows_changing_a_members_password() : void
    {
        $hasher = app(Hasher::class);
        $account = factory(Account::class)->create([
            'password' => $hasher->make('Hello world')
        ]);

        auth()->login($account);

        $this->visit(action([ProfileController::class, 'index']))
            ->see('change your password')
            ->visit(action([PasswordController::class, 'index']))
            ->type('Hello world', 'current_password')
            ->type('Hello world!', 'password')
            ->press('Change password')
            ->seePageIs(action([ProfileController::class, 'index']));

        $account->refresh();
        $this->assertTrue($hasher->check('Hello world!', $account->password));
    }
}
