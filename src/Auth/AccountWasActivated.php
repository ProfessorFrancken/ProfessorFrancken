<?php

declare(strict_types=1);

namespace Francken\Auth;

final class AccountWasActivated
{
    private int $account_id;

    public function __construct(Account $account)
    {
        $this->account_id = $account->id;
    }

    public function accountId() : int
    {
        return $this->account_id;
    }
}
