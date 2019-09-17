<?php

declare(strict_types=1);

namespace Francken\Features;

use Auth;
use Francken\Auth\Account;

trait LoggedInAsAdmin
{
    /**
     * @before
     */
    public function login() : void
    {
        $this->afterApplicationCreated(function () : void {
            \Artisan::call('permission:setup');

            $passphrase = config('francken.general.admin_passphrase');

            $account = Account::create([
                'member_id' => 1403,
                'email' => 'board@professorfrancken.nl',
                'password' => bcrypt($passphrase),
            ]);
            $account->assignRole('Admin');
            Auth::loginUsingId($account->id);
        });
    }
}
