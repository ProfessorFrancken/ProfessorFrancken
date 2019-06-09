<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\Factory as View;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $view = $this->app->make(View::class);

        $view->composer(
            'profile.*',
            LoggedInAsMemberComposer::class
        );
    }
}
