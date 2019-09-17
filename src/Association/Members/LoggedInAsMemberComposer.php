<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Illuminate\View\View;

final class LoggedInAsMemberComposer
{
    private $profile;

    public function __construct()
    {
        $franckenId = \Auth::user()->member_id;

        $lid = \DB::connection('francken-legacy')
            ->table('leden')
            ->where('id', $franckenId)
            ->first();

        $this->profile = $lid;
    }

    public function compose(View $view) : void
    {
        $view->with([
          'profile' => $this->profile,
          'member' => new Member($this->profile)
        ]);
    }
}
