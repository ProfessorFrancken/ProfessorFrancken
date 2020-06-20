<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Francken\Association\Members\Registration\EventHandlers;
use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use Francken\Association\Members\Registration\Events\RegistrationWasSubmitted;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\Factory as View;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot() : void
    {
        $view = $this->app->make(View::class);

        $view->composer(
            'profile.*',
            LoggedInAsMemberComposer::class
        );

        $dispatcher = $this->app->make(Dispatcher::class);
        $this->subscribeToRegistrationEvents($dispatcher);
    }

    private function subscribeToRegistrationEvents(Dispatcher $events) : void
    {
        $events->listen(
            RegistrationWasSubmitted::class,
            EventHandlers\NotifyBoardAboutRegistration::class
        );
        $events->listen(
            RegistrationWasSubmitted::class,
            EventHandlers\ConfirmRegistrationRequest::class
        );
    }
}
