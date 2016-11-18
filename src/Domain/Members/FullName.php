<?php

declare(strict_types=1);

namespace Francken\Domain\Members;

use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Serializable;

final class FullName implements SerializableInterface
{
    use Serializable;

    private $firstname;
    private $surname;
    private $middlename;

    public function __construct(
        string $firstname,
        string $middlename = null,
        string $surname
    ) {
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->middlename = $middlename;
    }

    public function fullName() : string
    {
        return implode(' ', array_filter([
            $this->firstname,
            $this->middlename,
            $this->surname
        ], function (string $name = null) {
            // Don't include additional spaces if for example middlename was empty
            return ! empty($name);
        }));
    }

    public function firstname() : string
    {
        return $this->firstname;
    }

    public function middlename() : string
    {
        return $this->middlename;
    }

    public function surname() : string
    {
        return $this->surname;
    }
}
