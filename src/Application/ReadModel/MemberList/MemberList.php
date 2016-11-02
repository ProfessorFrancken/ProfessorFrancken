<?php

namespace Francken\Application\ReadModel\MemberList;

use BroadwaySerialization\Serialization\Serializable;
use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Members\MemberId;

final class MemberList implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $first_name;
    private $last_name;

    public function __construct(MemberId $id, string $firstName, string $lastName)
    {
        $this->id = (string)$id;
        $this->first_name = $firstName;
        $this->last_name = $lastName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function memberId() : MemberId
    {
        return new MemberId($this->id);
    }

    public function firstName() : string
    {
        return $this->first_name;
    }

    public function lastName() : string
    {
        return $this->last_name;
    }

    public function fullName() : string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
