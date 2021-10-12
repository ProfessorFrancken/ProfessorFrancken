<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Francken\Association\Boards\Board;
use Francken\Association\Committees\Committee;
use Francken\Association\Committees\CommitteeMember;
use Illuminate\Support\Collection;

final class CommitteesController
{
    public function index() : Collection
    {
        /** @var Board $board */
        $board = Board::with(['committees.members.member'])
               ->whereNotNull('installed_at')
               ->orderBy('installed_at', 'desc')
               ->firstOrFail();

        return collect([
            'committees' =>
            $board->committees->flatMap(
                fn (Committee $committee) => $committee->members->map(
                    fn (CommitteeMember $member) : array => [
                        'commissie_id' => $member->committee_id,
                        'lid_id' => $member->member_id,
                        'jaar' => (int) $board->installed_at->format('Y'),
                        'functie' => $member->function,
                        'naam' => $committee->name
                    ]
                )
            )
        ]);
    }
}
