<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Database\DatabaseManager;

final class CommitteesController
{
    private $committees;

    public function __construct(DatabaseManager $db)
    {
        $this->committees = $db->connection('francken-legacy')
                      ->table('commissie_lid');
    }

    public function index()
    {
        $selects = ['commissie_id', 'lid_id', 'jaar', 'functie', 'commissies.naam'];
        $members = $this->committees->leftJoin('commissies', 'commissies.id', 'commissie_lid.commissie_id')
                 ->select($selects)
                 ->where('commissies.naam', '<>', 'bestuur')
                 ->orderBy('commissies.naam', 'ASC')
                 // ->where('jaar', '2016')
                 ->get();

        return collect(['committees' => $members]);
    }
}
