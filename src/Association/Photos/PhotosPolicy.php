<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Francken\Auth\Account;
use Francken\Shared\Settings\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

final class PhotosPolicy
{
    use HandlesAuthorization;

    private PhotosAuthentication $auth;

    private bool $are_albums_public;

    public function __construct(PhotosAuthentication $auth, Settings $settings)
    {
        $this->auth = $auth;
        $this->are_albums_public = ! $settings->areAlbumsPrivate();
    }

    public function view(?Account $account) : bool
    {
        return $this->are_albums_public || $this->viewPrivate($account);
    }

    public function viewPrivate(?Account $account) : bool
    {
        return $this->allowed($account);
    }

    private function allowed(?Account $account = null) : bool
    {
        return $account !== null || $this->auth->isLoggedIn();
    }
}
