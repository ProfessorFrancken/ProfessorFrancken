<?php

declare(strict_types=1);

namespace Francken\PlusOne;

use DateInterval;
use DateTimeImmutable;
use Lcobucci\JWT\Builder;
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

        return (new Builder())
               ->setIssuedAt($now)
               ->setExpiration($this->expiration($now))
               ->set('plus-one', true)
               ->getToken(new Sha256(), new InMemory($this->key));
    }

    private function expiration(DateTimeImmutable $now) : DateTimeImmutable
    {
        // Currently set the expiration date to next year, later we could change
        // this to be dependent on the user who's trying to login
        return $now->add(new DateInterval('P1Y'));
    }
}
