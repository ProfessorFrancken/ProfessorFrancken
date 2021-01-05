<?php

declare(strict_types=1);

namespace Francken\Extern;

class JobType
{
    /**
     * @var array<string, string>
     */
    public const TYPES = [
        "Fulltime" => "hourglass",
        "Part-time" => "hourglass-half",
        "Internship" => "info-circle"
    ];

    public static function all() : array
    {
        return collect(array_keys(self::TYPES))->mapWithKeys(fn (string $type) : array => [$type => $type])->all();
    }
}
