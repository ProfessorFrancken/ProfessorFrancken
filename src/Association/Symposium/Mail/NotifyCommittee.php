<?php

declare(strict_types=1);

namespace Francken\Association\Symposium\Mail;

use Francken\Association\Symposium\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyCommittee extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Participant
     */
    public $participant;

    protected $theme = 'symposium';

    /**
     * @var string
     */
    private $who_needs_to_take_an_adt;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Participant $participant, string $who_needs_to_take_an_adt)
    {
        $this->participant = $participant;
        $this->who_needs_to_take_an_adt = $who_needs_to_take_an_adt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Feest! Iemand heeft zich ingeschreven!")
            ->markdown('symposium.mails.notify_committee', [
                'full_name' => $this->participant->full_name,
                'who_needs_to_take_an_adt' => $this->who_needs_to_take_an_adt
            ]);
    }
}
