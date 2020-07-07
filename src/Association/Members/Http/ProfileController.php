<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Francken\Association\Committees\Committee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class ProfileController
{
    public function index(Request $request) : View
    {
        $member = $request->user()->member;

        $committees = Committee::with(['board'])
            ->whereHas('members', function (Builder $query) use ($member) : Builder {
                return $query->where('member_id', $member->id);
            })
            ->get()
            ->sortByDesc(function (Committee $committee) {
                return $committee->board->installed_at;
            });

        return view('profile.index')
            ->with([
                'member' => $member,
                'committees' => $committees,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                ]
            ]);
    }
}
