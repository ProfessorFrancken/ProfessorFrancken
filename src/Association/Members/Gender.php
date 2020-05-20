<?php

declare(strict_types=1);

namespace Francken\Association\Members;

final class Gender
{
    public const FEMALE = 'female';
    public const MALE = 'male';

    private $gender;

    private function __construct(string $gender)
    {
        $this->gender = $gender;
    }
   
    public function toString() : string
    {
        return $this->gender;
    }

    public static function female() : self
    {
        return new self(self::FEMALE);
    }

    public static function male() : self
    {
        return new self(self::MALE);
    }

    public static function other(string $gender) : self
    {
        return new self($gender);
    }

    public static function fromString(string $gender) : self
    {
        return new self($gender);
    }
}
