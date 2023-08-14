<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class MembersController
{
    private Builder $members;

    private ConnectionInterface $db;

    public function __construct(ConnectionResolverInterface $db)
    {
        $this->db = $db->connection('francken-legacy');
        $this->members = $db->connection('francken-legacy')
            ->table('leden');
    }

    public function index() : Collection
    {
        // For each member we want to find the date of their latest purchase,
        // so that we can give a warning when someone wants to make an order
        // on a member who has not purchased anything lately
        $latestPurchasePerMember = $this->db->table('transacties')
            ->select(['lid_id', DB::raw('MAX(tijd) as latest_purchase_at')])
            ->groupBy('lid_id');

        $members = $this->members
            ->leftJoin('leden_extras', 'leden.id', 'leden_extras.lid_id')
            ->leftJoinSub(
                $latestPurchasePerMember,
                'latest_transaction',
                fn ($join) => $join->on('leden.id', '=', 'latest_transaction.lid_id')
            )
            ->select([
                'id',
                'voornaam',
                'initialen',
                'tussenvoegsel',
                'achternaam',
                'geboortedatum',
                'prominent',
                'kleur',
                'afbeelding',
                'bijnaam',
                'button_width',
                'button_height',
                'latest_transaction.latest_purchase_at'
            ])
            ->where('is_lid', 1)
            ->where('streeplijst', 'Afschrijven')
            ->where('machtiging', 1)
            ->whereNull('einde_lidmaatschap')
            ->whereNull('deleted_at')
            ->where('id', '<>', 1098) // filter out Guests
            ->get()
            ->map(function ($lid) {
                if ($lid->afbeelding !== null && ! str_starts_with($lid->afbeelding, 'https://professorfrancken.nl')) {
                    $lid->afbeelding = "https://professorfrancken.nl/database/streep/afbeeldingen/{$lid->afbeelding}";
                }
                return $lid;
            });

        return collect(['members' => $members]);
    }
}
