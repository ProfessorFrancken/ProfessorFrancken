<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration\Mail;

use Francken\Association\Members\Registration\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Routing\UrlGenerator;

class ConfirmRegistrationRequest extends Mailable
{
    use Queueable, SerializesModels;

    public Registration $registration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(UrlGenerator $urlGenerator)
    {
        $url = $urlGenerator->signedRoute(
            'registration.verify',
            ['registration' => $this->registration->id]
        );

        return $this->subject(
            sprintf(
                "Hi %s, thank you for registering",
                $this->registration->fullname->toString()
            )
        )->markdown('association.members.registration.mail.confirm-registration', [
            'fullname' => $this->registration->fullname->toString(),
            'email_verification_url' => $url,
        ]);
    }
}
