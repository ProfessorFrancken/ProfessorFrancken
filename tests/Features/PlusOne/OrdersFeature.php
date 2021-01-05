<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Association\LegacyMember;
use Francken\Features\TestCase;
use Francken\PlusOne\Http\OrdersController;
use Francken\PlusOne\JwtToken;
use Francken\Treasurer\Product;
use Francken\Treasurer\Transaction;

class OrdersFeature extends TestCase
{
    /** @test */
    public function it_returns_lastest_orders() : void
    {
        $token = new JwtToken(config('francken.plus_one.key'));
        factory(Transaction::class, 10)->create();

        $this->json('GET', action([OrdersController::class, 'index']), [], ['Authorization' => 'Bearer ' . (string)$token->token()])
            ->assertResponseStatus(200)
            ->seeJsonStructure([
                'orders' => [[
                    'id',
                    'member_id',
                    'product_id',
                    'amount',
                    'ordered_at',
                    'price',
                ]]
            ]);
    }

    /** @test */
    public function it_can_buy_an_order() : void
    {
        $member = factory(LegacyMember::class)->create();
        $hertog = factory(Product::class)->create([
            'naam' => 'Hertog Jan',
            'prijs' => 68
        ]);
        $gebouw13 = factory(Product::class)->create([
            'naam' => 'Gebouw 13',
            'prijs' => 100
        ]);

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
                "ordered_at" => 1_522_075_374_402
            ]
        ];

        $token = new JwtToken(config('francken.plus_one.key'));
        $this->post(action([OrdersController::class, 'store']), $order, ['Authorization' => 'Bearer ' . (string)$token->token()]);
        $this->assertResponseStatus(201);
    }
}
