<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Http;

use Francken\Association\Symposium\Mail\InformationEmail;
use Francken\Association\Symposium\Mail\NotifyCommittee;
use Francken\Association\Symposium\Mail\VerifyRegistration;
use Francken\Association\Symposium\Participant;
use Francken\Association\Symposium\Symposium;
use Illuminate\Mail\Mailable;

final class AdminSymposiaMailPreviewController
{
    public function notifyCommittee(Symposium $symposium) : Mailable
    {
        $mail = new NotifyCommittee($this->participant($symposium), 'hoi');

        return $mail->build();
    }

    public function information(Symposium $symposium) : Mailable
    {
        $mail = new InformationEmail($this->participant($symposium));

        return $mail->build();
    }

    public function verify(Symposium $symposium) : Mailable
    {
        $mail = new VerifyRegistration($this->participant($symposium));

        return $mail->build();
    }

    private function participant(Symposium $symposium) : Participant
    {
        $participant = new Participant([
            'firstname' => 'Mark',
            'lastname' => 'Redeman'
        ]);
        $participant->symposium = $symposium;
        $participant->id = 1;

        return $participant;
    }
}
