<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Imports;

use Illuminate\Database\ConnectionInterface;
use Francken\Association\Boards\Board;
use Francken\Association\Boards\BoardMember;
use Illuminate\Database\Connection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeImport;
use Plank\Mediable\MediaUploader;

final class BoardsWithMembersImport implements WithMultipleSheets, WithEvents
{
    private Connection $db;

    private MediaUploader $uploader;

    public function __construct(ConnectionInterface $db, MediaUploader $uploader)
    {
        $this->db = $db;
        $this->uploader = $uploader;
    }

    public function sheets() : array
    {
        return [
            'Boards' => new BoardsImport($this->uploader),
            'Board members' => new BoardMembersImport($this->uploader)
        ];
    }

    public function registerEvents() : array
    {
        return [
            /**
             * Since our spreadsheet contains a board members sheet wich reference
             * the board that the member is in by its id we will first have to
             * truncate the boards table so that we can explicitely wet the ids
             * of the board and board members, without having to deal with
             * duplicate keys.
             */
            BeforeImport::class => function (BeforeImport $event) : void {
                // Remove all associated media before reuploading them
                Board::all()->each(function (Board $board) : void {
                    $board->members->each(function (BoardMember $member) : void {
                        $member->detachMediaTags('board_member_photo');
                    });
                    $board->detachMediaTags('board_photo');
                });
                $this->db->statement('SET FOREIGN_KEY_CHECKS=0;');
                $this->db->table('association_board_members')->truncate();
                $this->db->table('association_boards')->truncate();
                $this->db->statement('SET FOREIGN_KEY_CHECKS=1;');
            },
        ];
    }
}
