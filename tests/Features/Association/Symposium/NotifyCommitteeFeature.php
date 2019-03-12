<?php

declare(strict_types=1);

namespace Francken\Features\Association\Symposium;

use Francken\Association\Symposium\Mail\NotifyCommittee as NotifyCommitteeMail;
use Francken\Association\Symposium\NotifySymposiumCommittee;
use Francken\Association\Symposium\Participant;
use Francken\Association\Symposium\ParticipantRegisteredForSymposium;
use Francken\Association\Symposium\Symposium;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;

class NotifyCommitteeFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function it_sends_a_notification_email_to_the_committee() : void
    {
        $symposium = new Symposium();
        $participant = new Participant([
            'email' => 'markredeman@gmail.com',
            'firstname' => 'Mark',
            'lastname' => 'Redeman',
        ]);

        $event = new ParticipantRegisteredForSymposium($participant);

        Mail::fake();
        $listener = $this->app->make(NotifySymposiumCommittee::class);

        $listener->handle($event);

        Mail::assertSent(
            NotifyCommitteeMail::class,
            function ($mail) use ($participant) {
                return $mail->participant == $participant;
            });
    }
}
