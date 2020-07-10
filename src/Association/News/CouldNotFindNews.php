<?php

declare(strict_types=1);

namespace Francken\Association\News;

use OutOfBoundsException;

final class CouldNotFindNews extends OutOfBoundsException
{
    public static function forLink(string $link) : self
    {
        return new self("Could not find news with link, [$link]");
    }
}
