<?php

declare(strict_types=1);

namespace Francken\Features;

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

        $order = [
            "order" => [
                "member" => [
                    "id" => 1403,
                    "firstName" => "Mark",
                    "surname" => "Redeman",
                ],
                "products" => [
                    ["id" => 3, "name" => "Hertog Jan", "price" => 68],
                    ["id" => 172, "name" => "Gebouw 13", "price" => 100]
                ],
                "ordered_at" => 1522075374402
            ]
        ];

        $this->post('/api/plus-one/orders', $order, ['Authorization' => 'Bearer ' . $token]);

        $this->assertResponseStatus(201);
    }
}
