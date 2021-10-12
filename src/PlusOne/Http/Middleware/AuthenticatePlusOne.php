<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Log;
use Symfony\Component\HttpFoundation\Response;

final class AuthenticatePlusOne
{
    /**
     * Handle an incoming reques And verify if token exists and is valid
     */
    public function handle(Request $request, Closure $next) : Response
    {
        $token = $request->bearerToken();

        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(config('francken.plus_one.key'))
        );

        $configuration->setValidationConstraints(
            new SignedWith($configuration->signer(), $configuration->signingKey())
        );

        if ( ! $token) {
            $ip = $request->ip();
            Log::warning('Unauthorized plus one request', ['ip' => $ip]);

            return response('Unauthorized.', 403);
        }

        try {
            $token = $configuration->parser()->parse($token);

            if ( ! $configuration->validator()->validate($token, ...$configuration->validationConstraints())) {
                $ip = $request->ip();
                Log::warning('Unauthorized token request', ['ip' => $ip]);
                return response('Unauthorized data', 401);
            }

            return $next($request);
        } catch (Exception $e) {
            $ip = $request->ip();
            Log::warning('Unauthorized token request', ['ip' => $ip]);

            return response('Unauthorized: ' . $e->getMessage(), 403);
        }
    }
}
