<?php

declare(strict_types=1);

namespace Francken\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class JasFeature extends TestCase
{
    use DatabaseMigrations;

    /**
     * Checks if we can open the front page
     *
     * @test
     */
    public function it_stores_events_raised_by_our_jas_app() : void
    {
        $id = '8741e80e-153f-4254-b13e-21ac8ac34948';
        $this->json('POST', '/store-jas-events', [
            'id' => $id,
            'name' => 'GameStarted',
            'date' => 1503301742819,
            'payload' => [
                'game_id' => 'hoi'
            ]
        ])->seeJson([
            'created' => true
        ]);

        $this->seeInDatabase('jas_events', [
            'uuid' => $id,
            'name' => 'GameStarted',
            'date' => 1503301742819,
        ]);
    }
}
