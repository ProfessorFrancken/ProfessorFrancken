<?php

declare(strict_types=1);

namespace Francken\Infrastructure\EventSourcing;

use Broadway\EventStore\EventStoreException;
use Exception;

final class IlluminateEventStoreException extends EventStoreException
{
    public static function failedToAppend(Exception $exception) : void
    {
        throw new self(
            $exception->getMessage(),
            (int) $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
