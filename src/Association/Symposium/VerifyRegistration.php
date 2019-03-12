<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyRegistration implements ShouldQueue
{
    /**
     * @var Mailer
     */
    private $mail;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function handle(
        ParticipantRegisteredForSymposium $event
    ) : void {
        $participant = $event->participant;

        $this->mail->to($participant->email)
            ->send(new Mail\VerifyRegistration(
                $participant
            ));
    }
}
