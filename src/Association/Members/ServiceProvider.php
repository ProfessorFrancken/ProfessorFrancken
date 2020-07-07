<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Francken\Association\Members\Registration\EventHandlers\ConfirmRegistrationRequest;
use Francken\Association\Members\Registration\EventHandlers\NotifyBoardAboutRegistration;
use Francken\Association\Members\Registration\EventHandlers\NotifyMemberAboutMembership;
use Francken\Association\Members\Registration\EventHandlers\RegisterMember;
use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use Francken\Association\Members\Registration\Events\RegistrationWasSubmitted;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{
    public function boot() : void
    {
        $dispatcher = $this->app->make(Dispatcher::class);
        $this->subscribeToRegistrationEvents($dispatcher);
    }

    private function subscribeToRegistrationEvents(Dispatcher $events) : void
    {
        $events->listen(
            RegistrationWasSubmitted::class,
            NotifyBoardAboutRegistration::class
        );
        $events->listen(
            RegistrationWasSubmitted::class,
            ConfirmRegistrationRequest::class
        );
        $events->listen(
            RegistrationWasApproved::class,
            NotifyMemberAboutMembership::class
        );
        $events->listen(
            RegistrationWasApproved::class,
            RegisterMember::class
        );
    }
}
