<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Francken\Auth\Account;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\View\View;

final class LoggedInAsMemberComposer
{
    private $profile;

    public function __construct(Guard $auth)
    {
        /** @var Account|null $account */
        $account = $auth->user();

        if ($account === null || ! $account instanceof Account) {
            return;
        }

        $franckenId = $account->member_id;

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
