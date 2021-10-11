<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Features\TestCase;
use Francken\PlusOne\Http\CategoryStatisticsController;
use Francken\PlusOne\JwtToken;
use Francken\Treasurer\Transaction;

class CategoryStatisticsFeature extends TestCase
{
    /** @test */
    public function it_returns_statistics_related_to_the_consumption_counter() : void
    {
        $token = new JwtToken(config('francken.plus_one.key'));
        factory(Transaction::class, 10)->create(['tijd' => '2020-01-01 12:00:00']);

        $this->json(
            'GET',
            action([CategoryStatisticsController::class, 'index']),
            [
                'startDate' => '2020-01-01',
                'endDate' => '2020-02-01',
            ],
            ['Authorization' => 'Bearer ' . $token->token()->toString()]
        )
            ->assertResponseStatus(200)
            ->seeJsonStructure([
                'statistics' => [[
                    'date',
                    'beer',
                    'soda',
                    'food',
                ]]
            ]);
    }
}
