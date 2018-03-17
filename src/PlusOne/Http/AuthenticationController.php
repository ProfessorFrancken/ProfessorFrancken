<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Illuminate\Http\Request;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Hashing\Hasher;

final class AuthenticationController
{
    public function post(Request $request, Config $config)
    {
        if (! \Hash::check(
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

    private function token($key)
    {
        $now = time();

        $signer = new Sha256();
        $token = (new Builder())
               ->setIssuedAt($now)
               ->setExpiration($this->expiration($now))
               ->set('plus-one', true)
               ->sign($signer, $key)
               ->getToken();

        return $token;
    }

    private function expiration(int $now)
    {
        // Currently set the expiration date to next year, later we could change
        // this to be dependent on the user who's trying to login
        return $now + 3600 * 24 * 365;
    }
}
