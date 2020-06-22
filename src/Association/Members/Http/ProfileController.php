<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Francken\Association\Committees\CommitteesRepository;
use Francken\Association\Members\Member;

final class ProfileController
{
    private $profile;

    public function index(CommitteesRepository $committees)
    {
        $member = $this->member(request()->user());

        $committees = $committees->ofMember($member->id);

        return view('profile.index')
            ->with([
                'committees' => $committees,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                ]
            ]);
    }

    private function member($user)
    {
        $lid = \DB::connection('francken-legacy')
            ->table('leden')
            ->where('id', $user->member_id)
            ->first();

        $this->profile = $lid;

        return $lid;
    }
}
