<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Features\TestCase;
use Francken\PlusOne\Http\ProductsController;
use Francken\PlusOne\JwtToken;

class ProductsFeature extends TestCase
{
    /** @test */
    public function it_returns_available_products() : void
    {
        $token = new JwtToken(config('francken.plus_one.key'));

        $this->json('GET', action([ProductsController::class, 'index']), [], ['Authorization' => 'Bearer ' . (string)$token->token()])
            ->assertResponseStatus(200)
            ->seeJsonStructure([
                'products' => [[
                    'id',
                    'naam',
                    'prijs',
                    'categorie',
                    "positie",
                    "beschikbaar",
                    "afbeelding",
                    "btw",
                    "eenheden",
                    "created_at",
                    "updated_at",
                    "product_id",
                    "splash_afbeelding",
                    "kleur",
                ]]
            ]);
    }
}
