<?php

declare(strict_types=1);

namespace Francken\Shared;

use InvalidArgumentException;

final class Url
{
    private string $url;

    public function __construct(string $url)
    {
        if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException(
                sprintf("[%s] is not a valid URL", $url)
            );
        }

        $this->url = $url;
    }

    public function __toString() : string
    {
        return $this->url;
    }
}
