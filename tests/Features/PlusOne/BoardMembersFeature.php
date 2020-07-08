<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BoardMembersFeature extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_board_members_with_a_known_member_id() : void
    {
        $this->json('POST', '/api/plus-one/authenticate', [
            'password' => 'hoi',
        ]);
        $token = $this->response->decodeResponseJson()['token'];

        [$boardMember, $secondBoardMember] = $this->setupBoardMembers();
        $this->json(
            'GET',
            '/api/plus-one/boards',
            [],
            ['Authorization' => 'Bearer ' . $token]
        );
        $this->assertResponseStatus(200);
        $this->seeJsonStructure([
            'boardMembers' => [[
                "lid_id",
                "jaar",
                "functie"
            ]]
        ]);
        $this->seeJsonEquals([
            'boardMembers' => [
                [
                    'lid_id' => $boardMember->member_id,
                    'jaar' => (int)$boardMember->installed_at->format('Y'),
                    'functie' => $boardMember->title,
                ],
                [
                    'lid_id' => $secondBoardMember->member_id,
                    'jaar' => (int)$secondBoardMember->installed_at->format('Y'),
                    'functie' => $secondBoardMember->title,
                ],
            ]
        ]);
    }

    private function setupBoardMembers() : array
    {
        $board = factory(Board::class)->create([
            'installed_at' => '2020-06-06'
        ]);
        $boardMember = factory(BoardMember::class)->create([
            'board_id' => $board->id
        ]);
        // This member will be filtered out
        factory(BoardMember::class)->create([
            'member_id' => null,
            'board_id' => $board->id
        ]);
        $secondBoardMember = factory(BoardMember::class)->create([
            'board_id' => $board->id
        ]);

        return [$boardMember, $secondBoardMember];
    }
}
