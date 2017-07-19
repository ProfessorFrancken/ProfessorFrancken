<?php

declare(strict_types=1);

namespace Francken\Application\Career;

class JobType
{
    const TYPES = [
        "Fulltime" => "hourglass",
        "Part-time" => "hourglass-half",
        "Internship" => "info-circle"
    ];

    private $type;

    public function __construct(string $type)
    {
        if (! array_key_exists($type, self::TYPES)) {
            throw new \InvalidArgumentException(sprintf('[%s] is not a valid job type', $type));
        }

        $this->type = $type;
    }

    public static function fromString(string $type) : ?self
    {
        try {
            return new self($type);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    public function fontawesomeIcon() : string
    {
        return '';
    }

    public function __toString() : string
    {
        return $this->type;
    }
}
