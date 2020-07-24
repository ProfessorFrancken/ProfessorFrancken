<?php

declare(strict_types=1);

namespace Francken\Association\Newsletter;

use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Association\Newsletter\EventHandlers\SubscribeMemberToMailchimp;
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
            MemberWasRegistered::class,
            SubscribeMemberToMailchimp::class
        );
    }
}
