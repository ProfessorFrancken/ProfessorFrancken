<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Imports;

use Illuminate\Database\Connection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeImport;

final class BoardsWithMembersImport implements WithMultipleSheets, WithEvents
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function sheets() : array
    {
        return [
            'Boards' => new BoardsImport(),
            'Board members' => new BoardMembersImport()
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
                $this->db->statement('SET FOREIGN_KEY_CHECKS=0;');
                $this->db->table('association_board_members')->truncate();
                $this->db->table('association_boards')->truncate();
                $this->db->statement('SET FOREIGN_KEY_CHECKS=1;');
            },
        ];
    }
}
