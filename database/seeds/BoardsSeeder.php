<?php

declare(strict_types=1);

use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Francken\Association\Committees\Committee;
use Illuminate\Database\Eloquent\Model;
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
        $this->installBoardCommittees($boards);
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

    private function installBoardCommittees(Collection $boards) : void
    {
        $committees = collect();
        foreach ($boards as $board) {
            // Using continueFrom requries guarding our committee model as otherwise
            // it tries to overwrite the id column
            Model::reguard();

            // Continue about one third of the previous board's committees
            $continued_committees = $committees
                ->filter(fn () : bool => rand(0, 100) > 33)
                ->map(fn (Committee $committee) : Committee => Committee::continueFrom($committee, $board));

            $new_committees = factory(Committee::class, rand(0, 5))->create([
                'board_id' => $board->id,
                'is_public' => true
            ]);

            $committees = collect([
                ...$continued_committees,
                ...$new_committees
            ]);
        }
    }
}
