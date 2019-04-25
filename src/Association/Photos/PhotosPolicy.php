<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Auth\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

final class PhotosPolicy
{
    use HandlesAuthorization;

    /**
     * @var PhotosAuthentication
     */
    private $auth;


    public function __construct(PhotosAuthentication $auth)
    {
        $this->auth = $auth;
    }

    public function view(?Account $account) : bool
    {
        return $this->allowed($account);
    }

    private function allowed(?Account $account = null) : bool
    {
        return $account !== null || $this->auth->isLoggedIn();
    }
}
