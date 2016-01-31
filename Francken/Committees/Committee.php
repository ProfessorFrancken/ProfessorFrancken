<?php

namespace Francken\Committees;

use Broadway\EventSourcing\EventSourcedAggregateRoot;

use Francken\Committees\Events\CommitteeInstantiated;

class Committee extends EventSourcedAggregateRoot
{
    private $id;

    public static function instantiate(CommitteeId $id, $name, $goal)
    {
        $committee = new Committee;

        $committee->apply(new CommitteeInstantiated($id, $name, $goal));

        return $committee;
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }

}
