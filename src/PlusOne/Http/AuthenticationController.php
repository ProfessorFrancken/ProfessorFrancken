<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Francken\PlusOne\JwtToken;
use Hash;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;

final class AuthenticationController
{
    public function post(Request $request, Repository $config) : array
    {
        if ( ! Hash::check(
            $request->get('password'),
            $config->get('francken.plus_one.password')
        )) {
            abort(401, 'Invalid password');
        }

        $key = $config->get('francken.plus_one.key');
        $token = new JwtToken($key);

        return [
            "token" => $token->token()->toString()
        ];
    }
}
