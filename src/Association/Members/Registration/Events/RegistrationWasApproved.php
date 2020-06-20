<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration\Events;

use Francken\Association\Boards\BoardMember;
use Francken\Association\Members\Registration\Registration;
use Illuminate\Queue\SerializesModels;

final class RegistrationWasApproved
{
    use SerializesModels;

    public $registration;
    public $boardMember;

    public function __construct(Registration $registration, BoardMember $boardMember)
    {
        $this->registration = $registration;
        $this->boardMember = $boardMember;
    }
}
