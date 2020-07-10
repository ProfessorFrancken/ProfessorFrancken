<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Hash;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;

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

        return [
            "token" => (string)$this->token($key)
        ];
    }

    private function token(string $key) : Token
    {
        $now = time();

        $signer = new Sha256();

        return (new Builder())
               ->setIssuedAt($now)
               ->setExpiration($this->expiration($now))
               ->set('plus-one', true)
               ->sign($signer, $key)
               ->getToken();
    }

    private function expiration(int $now) : int
    {
        // Currently set the expiration date to next year, later we could change
        // this to be dependent on the user who's trying to login
        return $now + 3600 * 24 * 365;
    }
}
