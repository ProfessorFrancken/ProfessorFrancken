<?php

namespace Francken\Application\ReadModel\MemberList;

use BroadwaySerialization\Serialization\Serializable;
use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Members\MemberId;

final class MemberList implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $uuid;
    private $first_name;
    private $last_name;

    public function __construct(MemberId $id, string $firstName, string $lastName)
    {
        $this->uuid = (string)$id;
        $this->first_name = $firstName;
        $this->last_name = $lastName;
    }

    public function getId()
    {
        return $this->uuid;
    }
}
