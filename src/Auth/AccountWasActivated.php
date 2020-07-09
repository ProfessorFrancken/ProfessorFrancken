<?php

declare(strict_types=1);

namespace Francken\Auth;

final class AccountWasActivated
{
    private int $accountId;

    public function __construct(Account $account)
    {
        $this->accountId = $account->id;
    }

    public function accountId() : int
    {
        return $this->accountId;
    }
}
