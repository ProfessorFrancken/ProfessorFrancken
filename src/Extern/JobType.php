<?php

declare(strict_types=1);

namespace Francken\Extern;

class JobType
{
    /**
     * @var string[]
     */
    public const TYPES = [
        "Fulltime" => "hourglass",
        "Part-time" => "hourglass-half",
        "Internship" => "info-circle"
    ];

    public static function all() : array
    {
        return collect(array_keys(self::TYPES))->mapWithKeys(function (string $type) : array {
            return [$type => $type];
        })->all();
    }
}
