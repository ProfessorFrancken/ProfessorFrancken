<?php

namespace Francken\Application\Committees;

use Assert\Assertion;
use BroadwaySerialization\Serialization\Serializable;
use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;
use Francken\Domain\Committees\CommitteeId;
use Francken\Domain\Members\MemberId;
use Francken\Domain\Members\Email;

final class CommitteesList implements ReadModelInterface, SerializableInterface
{
    use Serializable;

    private $id;
    private $name;
    private $summary;
    private $email;
    private $markDown;
    private $html;
    private $members = [];

    public function __construct(
        CommitteeId $id,
        string $name,
        string $summary,
        Email $email = null,
        string $markDown = '',
        string $html = '',
        array $members = []
    ) {
        $this->id = (string)$id;
        $this->name = $name;
        $this->summary = $summary;
        $this->email = (string)$email;
        $this->markDown = $markDown;
        $this->html = $html;

        foreach ($members as $member) {
            Assertion::keyIsset($member, 'id');
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

    public function summary() : string
    {
        return $this->summary;
    }

    public function email()
    {
        if (empty($this->email)) {
            return null;
        }
        return new Email($this->email);
    }

    public function markDown() : string
    {
        return $this->markDown;
    }

    public function html() : string
    {
        return $this->html;
    }

    public function getId()
    {
        return $this->id;
    }

    public function changeEmail(Email $email = null)
    {
        $committee = clone $this;
        $committee->email = $email;
        return $committee;
    }

    public function changeCommitteePage(string $markDown, string $html)
    {
        return new CommitteesList($this->committeeId(), $this->name, $this->summary, $this->email(), $markDown, $html, $this->members);
    }

    public function changeName(string $name) : CommitteesList
    {
        return new CommitteesList($this->committeeId(), $name, $this->summary, $this->email(), $this->markDown, $this->html, $this->members);
    }

    public function changeGoal(string $summary) : CommitteesList
    {
        return new CommitteesList($this->committeeId(), $this->name, $summary, $this->email(), $this->markDown, $this->html, $this->members);
    }

    public function addMember(MemberId $memberId, string $firstName, string $lastName) : CommitteesList
    {
        return new CommitteesList(
            $this->committeeId(),
            $this->name,
            $this->summary,
            $this->email(),
            $this->markDown,
            $this->html,
            array_merge(
                $this->members,
                [[
                    "id" => (string)$memberId,
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
            $this->summary,
            $this->email(),
            $this->markDown,
            $this->html,
            array_filter(
                $this->members,
                function (array $member) use ($id) {
                    return ! ($member['id'] == (string)$id);
                }
            )
        );
    }
}
