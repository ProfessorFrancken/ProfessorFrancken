<?php

declare(strict_types=1);

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class BoardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $this->installBoards();

        $boards = Board::all();
        $this->installBoardMembers($boards);
    }

    private function installBoards() : void
    {
        $boards = collect(range(1990, 2020))->map(
            fn (int $year) => factory(Board::class)->make([
                'installed_at' => $year . '-06-06'
            ])
        );

        Board::insert($boards->toArray());
    }

    private function installBoardMembers(Collection $boards) : void
    {
        $members = $boards->flatMap(
            fn ($board) => factory(BoardMember::class, rand(3, 5))->make([
                'board_id' => $board->id
            ])
        );
        BoardMember::insert($members->toArray());
    }
}
