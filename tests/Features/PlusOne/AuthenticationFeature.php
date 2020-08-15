<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Features\TestCase;
use Francken\PlusOne\Http\AuthenticationController;

class AuthenticationFeature extends TestCase
{
    /** @test */
    public function it_retrieves_a_jwt_token_when_autenticating() : void
    {
        $this->json('POST', action([AuthenticationController::class, 'post']), [
            'password' => 'hoi',
        ]);

        $this->seeJsonStructure(['token']);
    }
}
