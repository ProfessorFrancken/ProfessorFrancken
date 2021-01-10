<?php

declare(strict_types=1);

namespace Francken\Features\Association\Symposium;

use DateTimeImmutable;
use Francken\Association\Symposium\Mail\NotifyCommittee;
use Francken\Association\Symposium\NotifySymposiumCommittee;
use Francken\Association\Symposium\ParticipantRegisteredForSymposium;
use Francken\Association\Symposium\Symposium;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Support\Facades\Mail;

class NotifyCommitteeFeature extends TestCase
{
    use LoggedInAsAdmin;

    /** @test */
    public function it_sends_a_notification_email_to_the_committee() : void
    {
        $symposium = Symposium::create([
            'name' => 'In a materialistic world',
            'start_date' => new DateTimeImmutable('05-05-2019 09:00'),
            'end_date' => new DateTimeImmutable('05-05-2019 18:00'),
            'location' => 'EM2',
            'website_url' => 'https://franckensymposium.nl',
            'open_for_registration' => true,
            'promote_on_agenda' => true,
        ]);
        $participant =$symposium->participants()->create([
            'email' => 'markredeman@gmail.com',
            'firstname' => 'Mark',
            'lastname' => 'Redeman',
            'is_francken_member' => true,
            'is_nnv_member' => true,
            'nnv_number' => '706116',
            'payment_method'=> 'debit',
            'iban' => 'NL18ABNA0484869868'
        ]);

        $event = new ParticipantRegisteredForSymposium($participant);

        Mail::fake();
        $listener = $this->app->make(NotifySymposiumCommittee::class);

        $listener->handle($event);

        Mail::assertSent(
            NotifyCommittee::class,
            fn ($mail) : bool => $mail->participant == $participant);
    }
}
