<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration\Mail;

use Francken\Association\Members\Http\Controllers\Admin\RegistrationRequestsController;
use Francken\Association\Members\Registration\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyBoardAboutRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Registration
     */
    public $registration;

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
    public function build()
    {
        return $this->subject(
            sprintf(
                "%s has subbmited a registration request",
                $this->registration->fullname->toString()
            )
        )->markdown('association.members.registration.mail.notify-board-about-registration', [
            'fullname' => $this->registration->fullname->toString(),
            'registration_details_url' => action(
                [RegistrationRequestsController::class, 'show'],
                ['registration' => $this->registration->id]
            ),
            'comments' => $this->registration->comments,
            'email' => $this->registration->email->toString(),
        ]);
    }
}
