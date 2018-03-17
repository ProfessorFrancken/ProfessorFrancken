<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Database\DatabaseManager;

final class BoardsController
{
    private $boards;

    public function __construct(DatabaseManager $db)
    {
        $this->boards = $db->connection('francken-legacy')
                      ->table('commissie_lid');
    }

    public function index()
    {
        $selects = ['lid_id', 'jaar', 'functie'];
        $members = $this->boards->leftJoin('commissies', 'commissies.id', 'commissie_lid.commissie_id')
                 ->select($selects)
                 ->where('commissies.naam', 'Bestuur')
                 ->get();

        return collect(['boardMembers' => $members]);
    }
}
