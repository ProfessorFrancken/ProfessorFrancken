<?php

declare(strict_types=1);

namespace Francken\Application\Members\Registration;

use Broadway\Domain\DomainMessage;
use DateTimeImmutable;
use Francken\Application\Projector;
use Francken\Domain\Members\Registration\Events\RegistrationRequestSubmitted;
use Francken\Domain\Members\Registration\RegistrationRequestId;

final class RequestStatusProjector extends Projector
{
    private $statuses;

    public function __construct(RequestStatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    public function whenRegistrationRequestSubmitted(RegistrationRequestSubmitted $event, DomainMessage $message)
    {
        $this->statuses->save(
            new RequestStatus(
                $event->registrationRequestId(),
                $event->FullName()->fullName(),
                false,
                false,
                false,
                false,
                DateTimeImmutable::createFromFormat(\Broadway\Domain\DateTime::FORMAT_STRING, $message->getRecordedOn()->toString())
            )
        );
    }
}
