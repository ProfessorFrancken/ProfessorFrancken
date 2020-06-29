<?php

declare(strict_types=1);

namespace Francken\PlusOne\Http;

use Francken\Association\Boards\BoardMember;

final class BoardsController
{
    public function index()
    {
        $members = BoardMember::with('member')->get()->filter(function (BoardMember $member) {
            return $member->member_id !== null;
        })->map(function (BoardMember $member) {
            return [
                'lid_id' => $member->member_id,
                'jaar' => (int) $member->installed_at->format('Y'),
                'functie' => $member->title,
            ];
        });

        return collect(['boardMembers' => $members]);
    }
}
