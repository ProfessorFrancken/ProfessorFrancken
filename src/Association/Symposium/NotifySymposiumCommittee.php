<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;

class NotifySymposiumCommittee implements ShouldQueue
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


        $who_needs_to_take_an_adt = Arr::random([
            'Carla', 'Leon', 'Jeanne', 'Braadslee', 'Justin', 'Rosa',
        ]);

        // This is very important
        AdCount::create([
            'symposium_id' => $participant->symposium_id,
            'participant_id' => $participant->id,
            'name' => $who_needs_to_take_an_adt,
            'consumed' => false,
        ]);


        $this->mail->to('sympfr@gmail.com')
            ->send(new Mail\NotifyCommittee(
                $participant,
                $who_needs_to_take_an_adt
            ));
    }
}
