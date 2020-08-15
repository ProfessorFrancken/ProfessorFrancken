<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Francken\Features\TestCase;
use Francken\PlusOne\Http\CommitteesController;
use Francken\PlusOne\JwtToken;

class CommitteesFeature extends TestCase
{
    /** @test */
    public function it_returns_committee_members() : void
    {
        $board = factory(Board::class)->create(['installed_at' => '2020-01-01']);
        $committees = factory(Committee::class, 3)->create(['board_id' =>$board->id]);

        $committees->each(function (Committee $committee) : void {
            factory(CommitteeMember::class, 5)
                ->create(['committee_id' => $committee->id]);
        });

        $token = new JwtToken(config('francken.plus_one.key'));

        $this->json('GET', action([CommitteesController::class, 'index']), [], ['Authorization' => 'Bearer ' . (string)$token->token()])
            ->assertResponseStatus(200)
            ->seeJsonStructure([
                'committees' => [[
                    'commissie_id',
                    'lid_id',
                    'jaar',
                    'functie',
                    'naam',
                ]]
            ]);
    }
}
