<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Mail;

use Francken\Association\Symposium\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyCommittee extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Participant $participant;

    /**
     * @var string
     */
    public $theme = 'symposium';

    private string $whoNeedsToTakeAnAdt;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Participant $participant, string $whoNeedsToTakeAnAdt)
    {
        $this->participant = $participant;
        $this->whoNeedsToTakeAnAdt = $whoNeedsToTakeAnAdt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() : self
    {
        return $this->subject(
            sprintf(
                "%s has registered, %s take a drink",
                $this->participant->fullname,
                $this->whoNeedsToTakeAnAdt
            )
        )->markdown('symposium.mails.notify_committee', [
            'fullname' => $this->participant->fullname,
            'who_needs_to_take_an_adt' => $this->whoNeedsToTakeAnAdt
        ]);
    }
}
