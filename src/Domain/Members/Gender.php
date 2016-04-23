<?php

namespace Francken\Domain\Members;

use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Base\Serializable;

final class Gender implements SerializableInterface {

    use Serializable;

    const FEMALE = 'female';
    const MALE = 'male';

    private $gender;

    private function __construct(string $gender)
    {
        $this->gender = $gender;
    }

    public static function fromString(string $gender) : Gender
    {
        if (! in_array($gender, [
            Gender::FEMALE, Gender::MALE
        ])) {
            throw new \InvalidArgumentException("{$gender} is not a valid gender");
        }

        return new Gender($gender);
    }

    public function __toString() : string
    {
        return $this->gender;
    }
}
