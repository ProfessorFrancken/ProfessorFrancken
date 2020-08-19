<?php

declare(strict_types=1);

namespace Francken\Shared\Providers;

use Francken\Shared\ViewComposers\MemberSelectionComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class ViewServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        $this->app->singleton(MemberSelectionComposer::class);

        View::composer(
            'admin.association.boards._member-selection',
            MemberSelectionComposer::class
        );
    }
}
