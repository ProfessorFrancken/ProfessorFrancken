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
            ->whereHas(
                'members',
                fn (Builder $query) : Builder => $query->where('member_id', $member->id)
            )
            ->get()
            ->sortByDesc(
                fn (Committee $committee) => optional($committee->board)->installed_at
            );

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
