<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionResolverInterface;
use DB;
use Illuminate\Database\DatabaseManager;

final class MembersController
{
    private Builder $members;
    private Connection $db;

    public function __construct(ConnectionResolverInterface $db)
    {
        $this->db = $db->connection('francken-legacy');
        $this->members = $db->connection('francken-legacy')
                       ->table('leden');
    }

    public function index(): Collection
    {
        $selects = ['id', 'voornaam', 'initialen', 'tussenvoegsel', 'achternaam', 'geboortedatum', 'prominent', 'kleur', 'afbeelding', 'bijnaam', 'button_width', 'button_height', 'transacties.latest_purchase_at'];

        // For each member we want to find the date of their latest purchase,
        // so that we can give a warning when someone wants to make an order
        // on a member who has not purchased anything lately
        $latestPurchasePerMember = $this->db->table('transacties')
                                 ->select(['lid_id', DB::raw('MAX(tijd) as latest_purchase_at')])
                                 ->groupBy('lid_id')
                                 ->toSql();

        $members = $this->members->leftJoin('leden_extras', 'leden.id', 'leden_extras.lid_id')
                 ->leftJoin(
                     DB::raw('(' . $latestPurchasePerMember . ') transacties'),
                     function ($join) {
                         return $join->on('leden.id', '=', 'transacties.lid_id');
                     }
                 )
                 ->select($selects)
                 ->where('is_lid', 1)
                 ->where('streeplijst', 'Afschrijven')
                 ->where('machtiging', 1)
                 ->whereNull('einde_lidmaatschap')
                 ->whereNull('deleted_at')
                 ->where('id', '<>', 1098) // filter out Guests
                 ->get()
                 ->map(function ($lid) {
                     if ($lid->afbeelding !== null) {
                         $lid->afbeelding = "https://old.professorfrancken.nl/database/streep/afbeeldingen/{$lid->afbeelding}";
                     }
                     return $lid;
                 });

        return collect(['members' => $members]);
    }
}
