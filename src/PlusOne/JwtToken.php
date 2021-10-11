<?php

declare(strict_types=1);

namespace Francken\PlusOne;

use DateInterval;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token;

class JwtToken
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function token() : Token
    {
        $now = new DateTimeImmutable();

        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($this->key)
        );

        return $configuration->builder()
               ->issuedAt($now)
               ->expiresAt($this->expiration($now))
               ->withClaim('plus-one', true)
               ->getToken($configuration->signer(), $configuration->signingKey());
    }

    private function expiration(DateTimeImmutable $now) : DateTimeImmutable
    {
        // Currently set the expiration date to next year, later we could change
        // this to be dependent on the user who's trying to login
        return $now->add(new DateInterval('P1Y'));
    }
}
