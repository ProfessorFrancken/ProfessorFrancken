<?php

declare(strict_types=1);

namespace Francken\Features;

use Auth;
use DB;

trait LoggedInAsAdmin
{
    /**
     * @before
     */
    public function login()
    {
        $this->afterApplicationCreated(function () {

            $passphrase = config('francken.general.admin_passphrase');

            DB::table('users')->insert([
                'id' => '1',
                'francken_id' => 1403,
                'email' => 'board@professorfrancken.nl',
                'password' => bcrypt($passphrase),
                'can_access_admin' => true
            ]);
            Auth::loginUsingId(1);

        });
    }
}
