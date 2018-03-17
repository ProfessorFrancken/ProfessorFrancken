<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http\Middleware;

use Closure;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Builder;
use Symfony\Component\HttpFoundation\Cookie;

final class AuthenticatePlusOne
{
    /**
     * Handle an incoming reques And verify if token exists and is valid
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response('Unauthorized.', 403);
        }

        try {
            $token = (new Parser())->parse((string)$token);

            if (! $token->validate(new ValidationData())) {
                return response('Unauthorized data', 401);
            }

            if (! $token->verify(
                new Sha256(),
                config('francken.plus_one.key')
            )) {
                return response('Unauthorized sign', 401);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response('Unauthorized: ' . $e->getMessage(), 403);
        }
    }
}
