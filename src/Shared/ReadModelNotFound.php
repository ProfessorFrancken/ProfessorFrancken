<?php

declare(strict_types=1);

namespace Francken\Shared;

use RuntimeException;

final class ReadModelNotFound extends RuntimeException
{
    public static function with(string $id) : self
    {
        return new self(
            sprintf('Could not find readmodel with id [%s]', $id)
        );
    }
}
