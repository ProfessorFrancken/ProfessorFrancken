<?php

declare(strict_types=1);

namespace Francken\Association\Members\Registration;

use Exception;

final class RegistrationException extends Exception
{
    public static function alreadyApproved() : self
    {
        return new self("Tried approving a registration that's been approved before");
    }
}
