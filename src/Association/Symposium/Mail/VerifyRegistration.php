<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Mail;

use Francken\Association\Symposium\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Webmozart\Assert\Assert;

class VerifyRegistration extends Mailable
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
        Assert::notNull($this->participant->symposium);

        return $this->subject("Please verify your registration for the '" . $this->participant->symposium->name . "' symposium")
            ->markdown('symposium.mails.verify', [
            'symposium' => $this->participant->symposium,
            'fullname' => $this->participant->fullname,
            'participant' => $this->participant,
            'location_url' => $this->participant->symposium->location_google_maps_url,
            'url' => $this->verificationUrl($this->participant),
            'is_francken_member' => $this->participant->is_francken_member,
            'is_nnv_member' => $this->participant->is_nnv_member,
            'pays_with_cash' => ! $this->participant->pays_with_iban,
        ]);
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl(Participant $participant) : string
    {
        return URL::signedRoute(
            'symposium.participant.verify',
            ["symposium" => $participant->symposium, "participant" => $participant]
        );
    }
}
