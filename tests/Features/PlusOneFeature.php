<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class PlusOneFeature extends TestCase
{
    /** @test */
    function it_retrieves_a_jwt_token_when_autenticating()
    {
        $this->json('POST', '/api/plus-one/authenticate', [
            'password' => 'hoi',
        ]);

        $this->assertArrayHasKey('token', $this->decodeResponseJson());
    }


    /** @test */
    function it_can_buy_an_order()
    {
        $this->json('POST', '/api/plus-one/authenticate', [
            'password' => 'hoi',
        ]);
        $token = $this->decodeResponseJson()['token'];

        $order = [
            "order" => [
                "member" => [
                    "id" => 1403,
                    "firstName" => "Mark",
                    "surname" => "Redeman",
                ],
                "products" => [
                    ["id" => 3,"name" => "Hertog Jan","price" => 68],
                    ["id" => 172,"name" => "Gebouw 13","price" => 100]
                ],
                "ordered_at" => 1522075374402
            ]
        ];

        $this->post('/api/orders', $order, ['Authorization' => 'Bearer ' . $token]);

        $this->assertResponseStatus(201);
    }
}
