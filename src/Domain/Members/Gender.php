<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Broadway\Serializer\Serializable as SerializableInterface;
use Francken\Domain\Serializable;

final class Gender implements SerializableInterface
{
    use Serializable;

    public const FEMALE = 'female';
    public const MALE = 'male';

    private $gender;

    private function __construct(string $gender)
    {
        $this->gender = $gender;
    }

    public function __toString() : string
    {
        return $this->gender;
    }

    public static function fromString(string $gender) : self
    {
        if ( ! in_array($gender, [
            self::FEMALE, self::MALE
        ], true)) {
            throw new \InvalidArgumentException("{$gender} is not a valid gender");
        }

        return new self($gender);
    }
}
