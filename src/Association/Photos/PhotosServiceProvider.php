<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\ServiceProvider;

final class PhotosServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate) : void
    {
        $gate->define('view-albums', [PhotosPolicy::class, 'view']);
        $gate->define('view-members-only-albums', [PhotosPolicy::class, 'viewMembersOnly']);
        $gate->define('view-private-albums', [PhotosPolicy::class, 'viewPrivate']);
    }

    public function register() : void
    {
        $this->app->bind(PhotosAuthentication::class, function () : PhotosAuthentication {
            $sessions = $this->app->make(Session::class);
            $hasher = $this->app->make(Hasher::class);

            return new PhotosAuthentication(
                $sessions,
                $hasher,
                config('francken.general.photos_hash')
            );
        });
    }
}
