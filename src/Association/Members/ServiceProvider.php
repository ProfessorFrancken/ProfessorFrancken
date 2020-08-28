<?php

declare(strict_types=1);

namespace Francken\Association\Members;

use Francken\Association\Borrelcie\EventHandlers\HandOutAnytimers;
use Francken\Association\Members\EventHandlers\ActivateAccount;
use Francken\Association\Members\EventHandlers\NotifyBoardAboutProfileChanges;
use Francken\Association\Members\Events\MemberAddressWasChanged;
use Francken\Association\Members\Events\MemberEmailWasChanged;
use Francken\Association\Members\Events\MemberPaymentDetailsWereChanged;
use Francken\Association\Members\Events\MemberPhoneNumberWasChanged;
use Francken\Association\Members\Registration\EventHandlers\ConfirmRegistrationRequest;
use Francken\Association\Members\Registration\EventHandlers\NotifyBoardAboutRegistration;
use Francken\Association\Members\Registration\EventHandlers\NotifyMemberAboutMembership;
use Francken\Association\Members\Registration\EventHandlers\RegisterMember;
use Francken\Association\Members\Registration\Events\MemberWasRegistered;
use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use Francken\Association\Members\Registration\Events\RegistrationWasSubmitted;
use Francken\Auth\AccountWasActivated;
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


        $events->listen(
            MemberEmailWasChanged::class,
            NotifyBoardAboutProfileChanges::class
        );
        $events->listen(
            MemberAddressWasChanged::class,
            NotifyBoardAboutProfileChanges::class
        );
        $events->listen(
            MemberPhoneNumberWasChanged::class,
            NotifyBoardAboutProfileChanges::class
        );
        $events->listen(
            MemberPaymentDetailsWereChanged::class,
            NotifyBoardAboutProfileChanges::class
        );

        $events->listen(
            MemberWasRegistered::class,
            ActivateAccount::class
        );
        $events->listen(
            AccountWasActivated::class,
            ActivateAccount::class
        );
        $events->listen(
            MemberWasRegistered::class,
            HandOutAnytimers::class
        );
    }
}
