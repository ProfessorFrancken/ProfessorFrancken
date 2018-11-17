<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use DateTimeImmutable;
use Francken\Association\Members\Member;
use Francken\Application\Committees\CommitteesRepository;

final class ProfileController
{
    private $profile;

    public function index(CommitteesRepository $committees)
    {
        $member = $this->member(request()->user());

        $committees = $committees->ofMember($member->id);

        return view('profile.index')
            ->with([
                'committees' => $committees
            ]);
    }

    public function edit()
    {
        return view('profile.edit');
    }

    private function member($user)
    {
        $lid = \DB::connection('francken-legacy')
            ->table('leden')
            ->where('id', $user->francken_id)
            ->first();

        $this->profile = $lid;

        return $lid;
    }
}
