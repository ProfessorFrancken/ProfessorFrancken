<?php

namespace Francken\Committees\Events;

use Francken\Committees\CommitteeId;

final class CommitteeInstantiated extends CommitteeEvent
{
    private $committeeId;
    private $name;
    private $goal;

    public function __construct(CommitteeId $committeeId, $name, $goal)
    {
        $this->committeeId = $committeeId;
        $this->name = $name;
        $this->goal = $goal;
    }

    public static function deserialize(array $data)
    {
        return new static(
            new CommitteeId($data['committeeId']),
            $data['name'],
            $data['goal']
        );
    }

    public function committeeId()
    {
        return $this->committeeId;
    }

    public function name()
    {
        return $this->name;
    }

    public function goal()
    {
        return $this->goal;
    }

    public function serialize()
    {
        return [
            'committeeId' => (string) $this->committeeId(),
            'name' => $this->name(),
            'goal' => $this->goal()
        ];
    }
}