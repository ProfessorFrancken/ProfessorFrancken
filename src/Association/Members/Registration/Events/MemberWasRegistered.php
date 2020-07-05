<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration\Events;

use Francken\Association\Members\Registration\Registration;
use Illuminate\Queue\SerializesModels;

final class MemberWasRegistered
{
    use SerializesModels;

    public Registration $registration;

    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }
}
