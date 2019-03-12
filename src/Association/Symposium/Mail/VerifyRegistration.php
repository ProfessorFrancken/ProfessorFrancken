<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Mail;

use Francken\Association\Symposium\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Participant
     */
    public $participant;

    protected $theme = 'symposium';

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
    public function build()
    {
        return $this->subject("Please verify your registration for the '" . $this->participant->symposium->name . "' symposium")
            ->markdown('symposium.mails.verify', [
            'full_name' => $this->participant->full_name,
            'participant' => $this->participant,
            'location_url' => 'https://www.google.com/maps/dir/?api=1&destination=EM2+VENUE,+Suikerlaan,+Groningen&travelmode=bicycling',
            'url' => $this->verificationUrl($this->participant),
            'is_francken_member' => $this->participant->is_francken_member,
            'is_nnv_member' => $this->participant->is_nnv_member,
            'pays_with_cash' => ! $this->participant->pays_with_iban,
        ]);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @return string
     */
    protected function verificationUrl($participant)
    {
        return URL::signedRoute(
            'symposium.participant.verify',
            [$participant->symposium_id, $participant->id]
        );
    }
}
