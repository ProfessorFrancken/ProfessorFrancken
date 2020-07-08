<?php

declare(strict_types=1);

namespace Francken\Features;

use Francken\Association\LegacyMember;
use Francken\Treasurer\Product;

class PlusOneFeature extends TestCase
{
    /** @test */
    public function it_retrieves_a_jwt_token_when_autenticating() : void
    {
        $this->json('POST', '/api/plus-one/authenticate', [
            'password' => 'hoi',
        ]);

        $this->seeJsonStructure(['token']);
    }


    /** @test */
    public function it_can_buy_an_order() : void
    {
        $this->json('POST', '/api/plus-one/authenticate', [
            'password' => 'hoi',
        ]);
        $token = $this->response->decodeResponseJson()['token'];

        $member = factory(LegacyMember::class)->create();
        $hertog = factory(Product::class)->create([
            'naam' => 'Hertog Jan',
            'prijs' => 68
        ]);
        $gebouw13 = factory(Product::class)->create([
            'naam' => 'Gebouw 13',
            'prijs' => 100
        ]);
        $this->withoutExceptionHandling();

        $order = [
            "order" => [
                "member" => [
                    "id" => $member->id,
                    "firstName" => $member->firstname,
                    "surname" => $member->surname,
                ],
                "products" => [
                    ["id" => $hertog->id, "name" =>  $hertog->name, "price" => $hertog->price],
                    ["id" => $gebouw13->id, "name" =>  $gebouw13->name, "price" => $gebouw13->price],
                ],
                "ordered_at" => 1522075374402
            ]
        ];

        $this->post('/api/plus-one/orders', $order, ['Authorization' => 'Bearer ' . $token]);

        $this->assertResponseStatus(201);
    }
}
