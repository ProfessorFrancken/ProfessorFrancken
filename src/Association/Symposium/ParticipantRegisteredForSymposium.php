<?php

declare(strict_types=1);

namespace Francken\Association\Symposium;

use Illuminate\Queue\SerializesModels;

final class ParticipantRegisteredForSymposium
{
    use SerializesModels;

    public Participant $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }
}
