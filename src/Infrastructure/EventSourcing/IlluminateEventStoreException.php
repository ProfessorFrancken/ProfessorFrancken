<?php

namespace Francken\Infrastructure\EventSourcing;

use Broadway\EventStore\EventStoreException;
use Exception;

final class IlluminateEventStoreException extends EventStoreException
{
    public static function failedToAppend(Exception $exception)
    {
        throw new IlluminateEventStoreException(
            $exception->getMessage(),
            (int) $exception->getCode(),
            $exception->getPrevious()
        );
    }
}
