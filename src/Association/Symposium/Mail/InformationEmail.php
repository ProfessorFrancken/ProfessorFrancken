<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Mail;

use Francken\Association\Symposium\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InformationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;
    
    public Participant $participant;

    /**
     * @var string
     */
    public $theme = 'symposium';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() : self
    {
        return $this->subject(
            "Symposium May 8th '" . $this->participant->symposium->name . "'"
        )->markdown('symposium.mails.information', [
            'full_name' => $this->participant->full_name,
            'participant' => $this->participant,
            'location_url' => 'https://www.google.com/maps/dir/?api=1&destination=De+Pudding,+Viaductstraat,+3-3,+Groningen&travelmode=bicycling',
            'schedule' => [
            ]
        ]);
    }
}
