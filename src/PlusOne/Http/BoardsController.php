<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Francken\Association\Boards\BoardMember;
use Illuminate\Support\Collection;

final class BoardsController
{
    public function index() : Collection
    {
        $members = BoardMember::with('member')
            ->get()
            ->filter(fn (BoardMember $member) : bool => $member->member_id !== null)
            ->map(fn (BoardMember $member) : array => [
                'lid_id' => $member->member_id,
                'jaar' => (int) $member->installed_at->format('Y'),
                'functie' => $member->title,
            ])->values();

        return collect(['boardMembers' => $members]);
    }
}
