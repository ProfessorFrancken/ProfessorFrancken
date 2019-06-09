<?php

declare(strict_types=1);

namespace Francken\Association\Boards\Http\Controllers;

use Illuminate\Database\DatabaseManager;

final class BirthdaysController
{
    private $boards;

    public function __construct(DatabaseManager $db)
    {
        $this->boards = $db->connection('francken-legacy')
                      ->table('commissie_lid');
    }

    public function index()
    {
        $today = (new \DatetimeImmutable())->sub(new \DateInterval('P1D'));

        $members = $this->boards
                 ->select(['leden.voornaam', 'leden.tussenvoegsel', 'leden.achternaam', 'leden.geboortedatum'])
                 ->join('leden', 'commissie_lid.lid_id', '=', 'leden.id')
                 ->where('commissie_lid.commissie_id', 14)
                 ->orderByRaw('DAYOFYEAR(leden.geboortedatum)')
                 ->get()
                 ->filter(function ($member) {
                     return $member->geboortedatum !== null;
                 })
                 ->map(function ($member) {
                     return [
                         'name' => implode(
                             ' ',
                             array_filter([$member->voornaam, $member->tussenvoegsel, $member->achternaam])
                         ),
                         'birthday' => new \DateTimeImmutable($member->geboortedatum)
                     ];
                 })->map(function ($member) use ($today) {
                     $birthdayInSameYearAsNow = $member['birthday']->setDate(
                         (int)$today->format('Y'),
                         (int)$member['birthday']->format('m'),
                         (int)$member['birthday']->format('d')
                     );

                     $birthday = $birthdayInSameYearAsNow->setDate(
                         (int)$birthdayInSameYearAsNow->format('Y') + ($today > $birthdayInSameYearAsNow ? 1 : 0),
                         (int)$birthdayInSameYearAsNow->format('m'),
                         (int)$birthdayInSameYearAsNow->format('d')
                     );

                     return array_merge($member, ['day' => $birthday]);

                 })->sortBy(function ($member) use ($today) {
                     return ($member['day']->getTimestamp() - $today->getTimestamp());
                 })->groupBy(function ($member) {
                     return $member['day']->format('Y');
                 })->map(function ($year) {
                     return $year->groupBy(function ($member) {
                         return $member['day']->format('F');
                     });
                 });

        return view(
            'association.board.birthdays',
            ['years' => $members, 'today' => new \DateTimeImmutable]
        );

        return collect($members);
    }
}
