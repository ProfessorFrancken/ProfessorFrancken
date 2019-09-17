<?php

declare(strict_types=1);

namespace Francken\Application;

final class ReadModelNotFound extends \RunTimeException
{
    public static function with(string $id) : self
    {
        return new self(
            sprintf('Could not find readmodel with id [%s]', $id)
        );
    }
}
