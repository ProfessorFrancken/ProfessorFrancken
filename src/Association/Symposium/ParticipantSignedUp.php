<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;

class ParticipantSignedUp extends Notification
{
    use Queueable;

    private $participant;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $who_needs_to_take_an_adt = Arr::random([
            'Eva',
            'Fristi',
            'Jesse',
            'Mark',
            'Bradley'
        ]);

        return (new MailMessage())
                    ->line('Hoi, ' . $this->participant->full_name . ' registered for the symposium.')
                    ->action('Notification Action', url('/'))
            ->line($who_needs_to_take_an_adt . ' needs to take an adt.')
                    ->line('Je bent fantastisch.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
