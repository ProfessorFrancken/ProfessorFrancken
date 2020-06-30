<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;

final class CommitteesController
{
    public function index()
    {
        $board = Board::with(['committees.members.member'])
               ->whereNotNull('installed_at')
               ->orderBy('installed_at', 'desc')
               ->first();

        return collect([
            'committees' =>
            $board->committees->flatMap(function (Committee $committee) use ($board) {
                return $committee->members->map(function (CommitteeMember $member) use ($committee, $board) {
                    return [
                        'commissie_id' => $member->committee_id,
                        'lid_id' => $member->member_id,
                        'jaar' => (int)$board->installed_at->format('Y'),
                        'functie' => $member->function,
                        'naam' => $committee->name
                    ];
                });
            })
        ]);
    }
}
