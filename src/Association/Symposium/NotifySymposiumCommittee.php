<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Francken\Association\Symposium\Mail\NotifyCommittee;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;

class NotifySymposiumCommittee implements ShouldQueue
{
    private Mailer $mail;

    public function __construct(Mailer $mail)
    {
        $this->mail = $mail;
    }

    public function handle(
        ParticipantRegisteredForSymposium $event
    ) : void {
        $participant = $event->participant;


        $whoNeedsToTakeAnAdt = Arr::random([
            'Carla', 'Leon', 'Jeanne', 'Braadslee', 'Justin', 'Rosa',
        ]);

        // This is very important
        AdCount::create([
            'symposium_id' => $participant->symposium_id,
            'participant_id' => $participant->id,
            'name' => $whoNeedsToTakeAnAdt,
            'consumed' => false,
        ]);


        $this->mail->to('sympfr@gmail.com')
            ->send(new NotifyCommittee(
                $participant,
                $whoNeedsToTakeAnAdt
            ));
    }
}
