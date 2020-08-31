<?php

declare(strict_types=1);

namespace Francken\Features\Association\Symposium;

use Francken\Association\Symposium\Mail\VerifyRegistration as VerifyRegistrationMail;
use Francken\Association\Symposium\Participant;
use Francken\Association\Symposium\ParticipantRegisteredForSymposium;
use Francken\Association\Symposium\Symposium;
use Francken\Association\Symposium\VerifyRegistration;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Support\Facades\Mail;

class VerificationEmailFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function a_verification_email_is_send() : void
    {
        $symposium = new Symposium();
        $participant = new Participant([
            'email' => 'markredeman@gmail.com',
            'firstname' => 'Mark',
            'lastname' => 'Redeman',
        ]);

        $event = new ParticipantRegisteredForSymposium($participant);

        Mail::fake();
        $listener = $this->app->make(VerifyRegistration::class);

        $listener->handle($event);

        Mail::assertSent(
            VerifyRegistrationMail::class,
            function ($mail) use ($participant) : bool {
                return $mail->participant == $participant;
            });
    }
}
