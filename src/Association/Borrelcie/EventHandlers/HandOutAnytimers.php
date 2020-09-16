<?php

declare(strict_types=1);

namespace Francken\Association\Borrelcie\EventHandlers;

use Francken\Association\Boards\Board;
use Francken\Association\Borrelcie\Anytimer;
use Francken\Association\Borrelcie\BorrelcieAccount;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Association\Members\Registration\Registration;
use Francken\Shared\EventHandler;
use Illuminate\Support\Collection;

final class HandOutAnytimers extends EventHandler
{
    public function whenMemberWasRegistered(MemberWasRegistered $event) : void
    {
        $totalApprovedRegistrations = Registration::query()->approved()->count();

        if ($totalApprovedRegistrations % 33 !== 0) {
            return;
        }

        $markBorrelcieAccount = BorrelcieAccount::where('member_id', 1403)->firstOrFail();

        $boardMemberAccounts = $this->boardMemberBorrelcieAccounts();
        $boardMemberAccounts->each(function (BorrelcieAccount $boardMemberAccount) use ($markBorrelcieAccount) : void {
            Anytimer::create([
                'drinker_id' => $markBorrelcieAccount->getKey(),
                'owner_id' => $boardMemberAccount->getKey(),
                'context' => 'given',
                'reason' => 'Getting (another) 33 registrations',
                'amount' => 1,
                'accepted' => false,
            ]);
        });
    }

    private function boardMemberBorrelcieAccounts() : Collection
    {
        $board = Board::current()->firstOrFail();

        return BorrelcieAccount::query()
            ->whereIn('member_id', $board->members->pluck('member_id'))
            ->get();
    }
}
