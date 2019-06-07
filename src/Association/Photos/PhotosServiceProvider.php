<?php

declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;

final class PhotosServiceProvider extends ServiceProvider
{
    public function boot(Gate $gate) : void
    {
        $gate->define('view-albums', [PhotosPolicy::class, 'view']);
        $gate->define('view-private-albums', [PhotosPolicy::class, 'viewPrivate']);
    }

    public function register() : void
    {
        $this->app->when(PhotosAuthentication::class)
          ->needs('$password_hash')
          ->give(config('francken.general.photos_hash'));
    }
}
