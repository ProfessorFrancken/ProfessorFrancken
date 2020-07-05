<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration\EventHandlers;

use Francken\Association\Members\Registration\Events\RegistrationWasApproved;
use Francken\Association\Members\Registration\Mail;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

final class NotifyMemberAboutMembership implements ShouldQueue
{
    private Mailer $mail;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function handle(RegistrationWasApproved $event) : void
    {
        $registration = $event->registration;

        $this->mail->to($registration->email->toString())
            ->send(new Mail\NotifyMemberAboutMembership($registration));
    }
}
