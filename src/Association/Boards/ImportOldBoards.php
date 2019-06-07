<?php

declare(strict_types=1);

namespace Francken\Association\Boards;

use Illuminate\Http\UploadedFile;
use DateInterval;
use Illuminate\Console\Command;
use Illuminate\Database\ConnectionInterface as DatabaseConnection;
use Illuminate\Support\Collection;

final class ImportOldBoards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boards:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all old boards into the database, should only be run once';

    private $boards;

    private $db;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BoardsRepository $boards, DatabaseConnection $db)
    {
        // We will need to have a database connection
        // and flikr api

        parent::__construct();

        $this->boards = $boards;
        $this->db = $db;
    }

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        BoardMember::query()->delete();
        Board::query()->delete();
        $boards = $this->boards->all();

        $boards->each(function (Board $board) {
            $board = $this->uploadBoardPhoto($board);
            $members = $board->members;
            unset($board->members);
            $board->save();
            $board->members()->createMany($members->toArray());

            // $members->each(function (BoardMember $member) {
            //     $member->save();
            // });
        });

        dd($boards, Board::with('members')->get()->toArray());
    }

    private function uploadBoardPhoto(Board $board) : Board
    {
        if ($board->photo === '') {
            return $board;
        }

        $photo = $this->downloadBoardPhoto($board);

        $board_year = BoardYear::fromInstallDate(
            $board->installed_at
        );
        $directory = "images/boards/{$board_year->toString()}";
        $name = $board->name !== '' ? $board->name : $board_year->toString();
        $photo_name = str_slug($name) . '.' . $photo->extension();

        $board->photo = asset(
            $photo->storePubliclyAs($directory, $photo_name, ['disk' => 'public'])
        );

        $board->members->each(function (BoardMember $member) use ($directory) {
            if ($member->photo === '' || $member->photo === null) {
                return;
            }

            $photo = $this->downloadBoardPhoto($member);
            $photo_name = str_slug($member->name) . '.' . $photo->extension();

            $member->photo = asset(
                $photo->storePubliclyAs($directory, $photo_name, ['disk' => 'public'])
            );
        });

        return $board;
    }

    private function downloadBoardPhoto($board) : UploadedFile
    {
        $url = $board->photo;
        $contents = file_get_contents($url);
        $info = pathinfo($url);
        $file = '/tmp/' . $info['basename'];
        file_put_contents($file, $contents);

        return new UploadedFile($file, $info['basename']);
    }
}
