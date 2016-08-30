<?php

declare(strict_types=1);

namespace Francken\Application;

final class ReadModelNotFound extends \RunTimeException
{
    public static function with(string $id) : ReadModelNotFound
    {
        return new ReadModelNotFound(
            sprintf('Could not find readmodel with id [%s]', $id)
        );
    }
}
