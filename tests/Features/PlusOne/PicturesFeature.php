<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Features\TestCase;
use Francken\PlusOne\Http\PicturesController;
use Francken\PlusOne\JwtToken;

class PicturesFeature extends TestCase
{
    /** @test */
    public function it_returns_available_products() : void
    {
        $token = new JwtToken(config('francken.plus_one.key'));

        $this->json('GET', action([PicturesController::class, 'show'], ['url' => 'hoi']), [], ['Authorization' => 'Bearer ' . (string)$token->token()])
             ->assertRedirectedTo('http://old.professorfrancken.nl/database/streep/afbeeldingen/hoi');
    }
}
