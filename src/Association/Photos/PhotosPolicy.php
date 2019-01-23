<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\GenericUser as User;

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

    public function view(?User $user) : bool
    {
        return $this->allowed($user);
    }

    private function allowed($user = null) : bool
    {
        return $user !== null || $this->auth->isLoggedIn();
    }
}
