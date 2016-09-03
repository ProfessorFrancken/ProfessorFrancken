<?php

namespace Francken\Application\ReadModel\CommitteesList;

use Assert\Assertion;
use BroadwaySerialization\Serialization\Serializable;
use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Members\MemberId;

final class CommitteesList implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $name;
    private $goal;
    private $members = [];

    public function __construct(
        CommitteeId $id,
        string $name,
        string $goal,
        array $members = []
    ) {

        $this->id = (string)$id;
        $this->name = $name;
        $this->goal = $goal;

        foreach ($members as $member) {
            Assertion::keyIsset($member, 'uuid');
            Assertion::keyIsset($member, 'first_name');
            Assertion::keyIsset($member, 'last_name');
        }
        $this->members = $members;
    }

    public function committeeId() : CommitteeId
    {
        return new CommitteeId($this->id);
    }

    public function members() : array
    {
        return $this->members;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function goal() : string
    {
        return $this->goal;
    }

    public function getId()
    {
        return $this->id;
    }

    public function changeName(string $name) : CommitteesList
    {
        return new CommitteesList($this->committeeId(), $name, $this->goal, $this->members);
    }

    public function changeGoal(string $goal) : CommitteesList
    {
        return new CommitteesList($this->committeeId(), $this->name, $goal, $this->members);
    }

    public function addMember(MemberId $memberId, string $firstName, string $lastName) : CommitteesList
    {
        return new CommitteesList(
            $this->committeeId(),
            $this->name,
            $this->goal,
            array_merge(
                $this->members,
                [[
                    "uuid" => (string)$memberId,
                    "first_name" => $firstName,
                    "last_name" => $lastName
                ]]
            )
        );
    }

    public function removeMember(MemberId $id) : CommitteesList
    {
        return new CommitteesList(
            $this->committeeId(),
            $this->name,
            $this->goal,
            array_filter(
                $this->members,
                function (array $member) use ($id) {
                    return ! ($member['uuid'] == (string)$id);
                }
            )
        );
    }
}
