<?php

namespace Francken\Application\ReadModel\CommitteesList;

use BroadwaySerialization\Serialization\Serializable;
use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Members\MemberId;

final class CommitteesList implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $uuid;
    private $name;
    private $goal;
    private $committee_members = [];

    public function __construct(CommitteeId $id, string $name, string $goal, array $members = [])
    {
        $this->uuid = (string)$id;
        $this->name = $name;
        $this->goal = $goal;
        $this->committee_members = $members;
    }

    public function members() : array
    {
        return $this->committee_members;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function goal() : string
    {
        return $this->goal;
    }

    public function changeName(string $name)
    {
        $this->name = $name;
    }

    public function changeGoal(string $goal)
    {
        $this->goal = $goal;
    }

    public function addMember(MemberId $memberId, string $firstName, string $lastName)
    {
        $members = $this->committee_members;

        $members[] = [
            "uuid" => (string)$memberId,
            "first_name" => $firstName,
            "last_name" => $lastName
        ];

        $this->committee_members = $members;
    }

    public function removeMember(MemberId $id)
    {
        $this->committee_members = array_filter(
            $this->committee_members,
            function (array $member) use ($id) {
                return ! ($member['uuid'] == (string)$id);
            }
        );
    }

    public function getId()
    {
        return $this->uuid;
    }
}
