<?php

declare(strict_types=1);

/**
 * Add links to
 * - whatsapp
 * - newsletter
 * - upcoming activitities
 */

namespace Francken\Association\Members\Registration\Mail;

use Francken\Association\Members\Registration\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMemberAboutMembership extends Mailable
{
    use Queueable;
    use SerializesModels;
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
    public function build(): self
    {
        return $this->subject(
            "Your membership at T.F.V. 'Professor Francken' has been approved"
        )->markdown('association.members.registration.mail.notify-member-about-membership', [
            'fullname' => $this->registration->fullname->toString()
        ]);
    }
}
