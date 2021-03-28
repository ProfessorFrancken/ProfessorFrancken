<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Mail;

use Francken\Association\Symposium\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Webmozart\Assert\Assert;

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
        Assert::notNull($this->participant->symposium);

        return $this->subject(
            "Symposium May 8th '" . $this->participant->symposium->name . "'"
        )->markdown('symposium.mails.information', [
            'symposium' => $this->participant->symposium,
            'participant' => $this->participant,
            'fullname' => $this->participant->fullname,
            'location_url' => $this->participant->symposium->location_google_maps_url,
            'schedule' => [
            ]
        ]);
    }
}
