<?php

declare(strict_types=1);

namespace Francken\Auth;

final class AccountWasActivated
{
    private $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
