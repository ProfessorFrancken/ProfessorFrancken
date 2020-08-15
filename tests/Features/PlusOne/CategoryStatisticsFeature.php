<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Features\TestCase;
use Francken\PlusOne\Http\CategoryStatisticsController;
use Francken\PlusOne\JwtToken;

class CategoryStatisticsFeature extends TestCase
{
    /** @test */
    public function it_returns_statistics_related_to_the_consumption_counter() : void
    {
        $token = new JwtToken(config('francken.plus_one.key'));

        $this->json('GET', action([CategoryStatisticsController::class, 'index']), [], ['Authorization' => 'Bearer ' . (string)$token->token()])
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
