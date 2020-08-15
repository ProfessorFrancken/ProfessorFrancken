<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Features\TestCase;
use Francken\PlusOne\Http\SponsorsController;
use Francken\PlusOne\JwtToken;

class SponsorsFeature extends TestCase
{
    /** @test */
    public function it_returns_active_sponsors_of_the_consumption_counter() : void
    {
        $token = new JwtToken(config('francken.plus_one.key'));

        $this->json('GET', action([SponsorsController::class, 'index']), [], ['Authorization' => 'Bearer ' . (string) $token->token()])
             ->seeJsonStructure([
                 'sponsors' => [[
                    'name',
                    'image'
                ]],
            ]);
    }
}
