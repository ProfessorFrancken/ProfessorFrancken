<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Illuminate\Database\DatabaseManager;

final class MembersController
{
    private $members;

    public function __construct(DatabaseManager $db)
    {
        $this->members = $db->connection('francken-legacy')
                       ->table('leden');
    }

    public function index()
    {

        // $db = DB::connection('francken-legacy');
        // $db->table('producten')->join('producten_extras', 'producten.id', 'producten_extras.product_id')->get();

        // file_put_contents(database_path('producten.json'), json_encode($producten));

        $selects = ['id', 'voornaam', 'initialen', 'tussenvoegsel', 'achternaam', 'geboortedatum', 'prominent', 'kleur', 'afbeelding', 'bijnaam', 'button_width', 'button_height'];

        $members = $this->members->leftJoin('leden_extras', 'leden.id', 'leden_extras.lid_id')
                 ->select($selects)->where('is_lid', 1)
                 ->where('streeplijst', 'Afschrijven')
                 ->where('machtiging', 1)
                 ->whereNull('einde_lidmaatschap')
                 ->whereNull('deleted_at')
                 ->where('id', '<>', 1098) // filter out Guests
                 ->get()
                 ->map(function ($lid) {
                     if ($lid->afbeelding !== null) {
                         $lid->afbeelding = "https:/old.professorfrancken.nl/database/streep/afbeeldingen/{$lid->afbeelding}";
                     }
                     return $lid;
                 });

        return collect(['members' => $members]);

        // file_put_contents(database_path(leden.json'), json_encode($leden));
    }
}
