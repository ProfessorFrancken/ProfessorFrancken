<?php

declare(strict_types=1);

namespace Francken\Domain;

final class Url
{
    private $url;

    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException;
        }

        $this->url = $url;
    }

    public function __toString() : string
    {
        return $this->url;
    }
}
